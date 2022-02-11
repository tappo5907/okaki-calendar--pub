<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Care extends Model
{
    /**
     * @return Carbon|null
     */
    public function getCareDateTime()
    {
        if ($this->care_datetime) {
            return new Carbon($this->care_datetime);
        }
        return null;
    }
    
    public function foodSupply()
    {
        return $this->hasOne(FoodSupply::class);
    }
}
