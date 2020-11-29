<?php

namespace App\Rules;

use App\Influencer;
use Illuminate\Contracts\Validation\Rule;

class InfluencerUsernameRule implements Rule
{
    /**
     * Influencer exists
     *
     * @var boolean
     */
    private $exists = false;

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
        $this->exists = Influencer::where((filter_var($value, FILTER_VALIDATE_INT) !== false ? 'account_id' : 'username'), $value)->first();

        return is_null($this->exists);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->exists ? 'Influencer already exists!' : 'Wrong influencer identify!';
    }
}
