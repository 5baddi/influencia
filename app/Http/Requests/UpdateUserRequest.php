<?php

namespace App\Http\Requests;

use App\Rules\UserRoleRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'        =>  'required|integer|exists:users,id',
            'name'      =>  'required|string|max:200',
            'password'  =>  'nullable|string',
            'role'      =>  ['required', new UserRoleRule()]
        ];
    }
}
