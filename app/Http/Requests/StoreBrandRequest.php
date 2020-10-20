<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('create_brand'), Response::HTTP_FORBIDDEN, "403 Forbidden");

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
            // 'id'        =>  'nullable|integer|exists:brands,id',
            'name'      =>  'required|string|unique:brands,name',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}