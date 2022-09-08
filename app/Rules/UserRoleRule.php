<?php

namespace App\Rules;

use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;

class UserRoleRule implements Rule
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
        // Is supper admin
        if(is_string($value) && $value == "super")
            return true;

        // Check if role already exists
        $role = Role::find($value);

        return !is_null($role);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected file doesn\'t exists!';
    }
}
