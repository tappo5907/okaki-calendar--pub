<?php

use Illuminate\Database\Seeder;

class DevFoodWeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateList = ['2020-08-13', '2020-08-14', '2020-08-15'];
        
        $insertList = [];
        foreach ($dateList as $date) {
            for ($i = 0; $i < 24; $i++) {
                $createdAt = $date . " " .sprintf('%02d:01:00', $i);
                $weight = $this->randomFloat();
                
                $insertList[] = [
                    'weight' => $weight,
                    'target_date' => $date,
                    'hour' => $i,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
        }
        
        DB::table('food_weights')->insert($insertList);
    }
    
    public function randomFloat($min = 0, $max = 100) {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 2);
    }
}
