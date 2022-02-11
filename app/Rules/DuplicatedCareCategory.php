<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Carbon\Carbon;

use App\Care;

class DuplicatedCareCategory implements Rule
{
    private $carbon;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = Care::query();
        
        $care = $query
            ->where('care_datetime', '>=', $this->carbon->format('Y-m-d 00:00:00'))
            ->where('care_datetime', '<=', $this->carbon->format('Y-m-d 23:59:59'))
            ->where('category', '=', $value)
            ->get()
        ;
        
        if (count($care) === 0) {
            // すでに登録がされていなければ、true
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This category is already registered.';
    }
}
