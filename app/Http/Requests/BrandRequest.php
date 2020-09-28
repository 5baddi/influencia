<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'id'        =>  'nullable|integer|exists:brands,id',
            'name'      =>  'required|string|unique:brands,name',
            'image'     =>  'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
