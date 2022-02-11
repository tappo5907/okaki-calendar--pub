<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Carbon\Carbon;

use App\Care;
use App\FoodSupply;
use App\Enums\CareCategory;
use App\Rules\DuplicatedCareCategory;

class CareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->year !== null && $request->month !== null) {
            // 年月があれば、その年月とする
            $dateStr = sprintf('%04d-%02d-01', $request->year, $request->month);
            $carbon = new Carbon($dateStr);
        } else {
            // 現在日時
            $carbon = Carbon::now();
        }
        $carbonCopyForCurrent = $carbon->copy();
        $carbonCopyForPrev = $carbon->copy();
        $carbonCopyForNext = $carbon->copy();
        $prev = $carbonCopyForPrev->addMonthsNoOverflow(-1);
        $next = $carbonCopyForNext->addMonthsNoOverflow(1);

        $calendarDays = $this->getCalendarDays($carbon);

        return view('cares.index', [
            'calendar_days' => $calendarDays,
            'current_year' => $carbonCopyForCurrent->year,
            'current_month' => $carbonCopyForCurrent->month,
            'prev_year' => $prev->year,
            'prev_month' => $prev->month,
            'next_year' => $next->year,
            'next_month' => $next->month,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dateStr = sprintf('%04d-%02d-%02d', $request->year, $request->month, $request->day);
        $carbon = new Carbon($dateStr);

        $care = new Care();

        return view('cares.create', [
            'care' => $care,
            'now' => $carbon,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        if (!$user->isOkakiUser()) {
            // 権限がなければ、リダイレクト
            return redirect("/");
        }
        
        // バリデーション
        $request->validate([
            'care_date' => 'required',
            'care_time' => 'required',
            'category' => 'required',
            'food_supply_amount' => 'integer|min:0|max:10000',
            'memo' => 'max:1000',
        ]);

        $careDateTime = new Carbon($request->care_date . ' ' . $request->care_time);

        // 同日・同カテゴリは登録しない
        $request->validate([
            'category' => [new DuplicatedCareCategory($careDateTime)],
        ]);

        $care = new Care();
        $care->care_datetime = $careDateTime;
        $care->category = $request->category;
        $care->memo = $request->memo;

        $care->save();
        
        // CareCategory::FOOD_SUPPLY の時 food_supply_amount を登録
        if ($care->category == CareCategory::FOOD_SUPPLY) {
            $care->foodSupply()->create([
                'amount' => $request->food_supply_amount,
            ]);
        }

        // トップページへリダイレクトさせる
        return redirect("/{$careDateTime->year}/{$careDateTime->month}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $care = Care::findOrFail($id);
        
        $foodSupplyAmount = null;
        if ($care->category == CareCategory::FOOD_SUPPLY) {
            $foodSupply = Arr::first($care->foodSupply()->get());
            $foodSupplyAmount = $foodSupply->amount;
        }

        return view('cares.edit', [
            'care' => $care,
            'food_supply_amount' => $foodSupplyAmount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \Auth::user();
        if (!$user->isOkakiUser()) {
            // 権限がなければ、リダイレクト
            return redirect("/");
        }
        
        $care = Care::findOrFail($id);

        // バリデーション
        $request->validate([
            'care_time' => 'required',
            'food_supply_amount' => 'integer|min:0|max:10000',
            'memo' => 'max:1000',
        ]);

        $careDateTime = $care->getCareDateTime();
        $updateCareDateTime = new Carbon($careDateTime->toDateString() . '' . $request->care_time);

        $care->care_datetime = $updateCareDateTime;
        $care->memo = $request->memo;

        $care->save();
        
        // CareCategory::FOOD_SUPPLY の時 food_supply_amount を登録
        if ($care->category == CareCategory::FOOD_SUPPLY) {
            $foodSupply = Arr::first($care->foodSupply()->get());
            $foodSupply->amount = $request->food_supply_amount;
            $foodSupply->save();
        }

        // トップページへリダイレクトさせる
        return redirect("/{$careDateTime->year}/{$careDateTime->month}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \Auth::user();
        if (!$user->isOkakiUser()) {
            // 権限がなければ、リダイレクト
            return redirect("/");
        }
        
        $care = Care::findOrFail($id);
        
        $careDateTime = $care->getCareDateTime();
        
        // CareCategory::FOOD_SUPPLY の時 food_supply_amount も削除
        if ($care->category == CareCategory::FOOD_SUPPLY) {
            $foodSupply = Arr::first($care->foodSupply()->get());
            FoodSupply::destroy($foodSupply->id);
        }

        Care::destroy($care->id);

        // トップページへリダイレクトさせる
        return redirect("/{$careDateTime->year}/{$careDateTime->month}");
    }
    
    public function getCalendarDays(Carbon $carbon)
    {
        $count = $carbon->lastOfMonth()->day;
        $carbon = $carbon->startOfMonth(); // 月初

        $days = [];

        for ($i = 0; $i < $count; $i++, $carbon->addDay()) {
            $cares = $this->findByCareDate($carbon);

            $days[] = [
                'cares' => $cares,
                'day' => $carbon->copy()
            ];
        }
        return $days;
    }
    
    // ここじゃないかも
    public function findByCareDate(Carbon $carbon)
    {
        $query = Care::query();
        
        $care = $query
            ->where('care_datetime', '>=', $carbon->format('Y-m-d 00:00:00'))
            ->where('care_datetime', '<=', $carbon->format('Y-m-d 23:59:59'))
            ->get()
        ;
        return $care;
    }
}
