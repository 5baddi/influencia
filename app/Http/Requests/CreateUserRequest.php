<?php

namespace App\Http\Requests;

use App\Rules\UserRoleRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('create_user') && Gate::denies('create', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     =>  'required|email|unique:users,email',
            'name'      =>  'required|string|max:200',
            'password'  =>  'required|string',
            'role'      =>  ['required', new UserRoleRule()]
        ];
    }
}
