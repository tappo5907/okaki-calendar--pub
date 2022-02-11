<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodSupply extends Model
{
    protected $fillable = ['amount'];
    
    public function care()
    {
        return $this->belongsTo(Care::class);
    }
}
