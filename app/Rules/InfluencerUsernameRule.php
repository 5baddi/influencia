<?php

namespace App\Rules;

use App\Influencer;
use Illuminate\Contracts\Validation\Rule;

class InfluencerUsernameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $exists = Influencer::where((filter_var($value, FILTER_VALIDATE_INT) !== false ? 'account_id' : 'username'), $value)->first();

        return is_null($exists);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wrong influencer identify!';
    }
}
