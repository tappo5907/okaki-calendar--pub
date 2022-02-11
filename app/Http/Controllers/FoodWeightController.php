<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\FoodWeight;
use App\Repository\FoodWeightRepository;

class FoodWeightController extends Controller
{
    /** @var FoodWeightRepository */
    private $foodWeightRepository;
    
    public function __construct()
    {
        $this->foodWeightRepository = new FoodWeightRepository();
    }
    
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->year !== null && 
            $request->month !== null &&
            $request->day !== null
        ) {
            // 年月があれば、その年月とする
            $dateStr = sprintf('%04d-%02d-%02d', $request->year, $request->month, $request->day);
            $carbon = new Carbon($dateStr);
        } else {
            // 現在日時
            $carbon = Carbon::now();
        }
        $foodWeights = $this->foodWeightRepository->findArrayByCreatedAt($carbon);
        
        $carbonCopyForPrev = $carbon->copy();
        $carbonCopyForNext = $carbon->copy();
        $prevDate = $carbonCopyForPrev->addDay(-1);
        $nextDate = $carbonCopyForNext->addDay(1);
        
        return view('food_weights.index', [
            'date' => $carbon,
            'foodWeightsJson' => json_encode($foodWeights),
            'prev_date' => $prevDate,
            'next_date' => $nextDate,
        ]);
    }
}
