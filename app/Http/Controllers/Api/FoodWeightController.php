<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\FoodWeight;
use App\Repository\FoodWeightRepository;

use App\Http\Controllers\Controller;

class FoodWeightController extends Controller
{
    public function store(Request $request)
    {
        $user = \Auth::user();
        if (!$user->isOkakiUser()) {
            // 権限がなければ、INVALID_USER
            return response()->json(['status' => 'INVALID_USER']);
        }
        \Log::debug($request->input('weight'));
        \Log::debug($request->input('weight_datetime'));
        // バリデーション
        $request->validate([
            'weight' => 'required|numeric',
            'weight_datetime' => 'required',
        ]);
        
        $weightDateTime = new Carbon($request->weight_datetime);
        $now = new Carbon();
        
        $foodWeight = new FoodWeight();
        $foodWeight->weight = $request->weight;
        $foodWeight->target_date = $weightDateTime->toDateString();
        $foodWeight->hour = $weightDateTime->hour;
        $foodWeight->save();
        
        return response()->json(['status' => 'OK']);
    }
}