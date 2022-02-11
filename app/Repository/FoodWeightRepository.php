<?php

namespace App\Repository;

use Carbon\Carbon;

use App\FoodWeight;

class FoodWeightRepository
{
    /**
     * @param Carbon $carbon
     * @return array [[ 'hour' => hour, 'weight' => weight ]]
     */
    public function findArrayByCreatedAt(Carbon $carbon)
    {
        $query = FoodWeight::query();
        
        $foodWeights = $query
            ->where('target_date', '=', $carbon->format('Y-m-d'))
            ->get()
        ;
        
        $result = [];
        foreach ($foodWeights as $foodWeight) {
            $result[] = [
                'hour' => $foodWeight->hour,
                'weight' => $foodWeight->weight,
            ];
        }
        
        return $result;
    }
}