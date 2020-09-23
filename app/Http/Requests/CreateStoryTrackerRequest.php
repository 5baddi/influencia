<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoryTrackerRequest extends FormRequest
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
            'user_id'       =>  'required|integer|exists:users,id',
            'campaign_id'   =>  'required|integer|exists:campaigns,id',
            'name'          =>  'required|unique:trackers,name|max:255',
            'type'          =>  'required|in:story',
            'platform'      =>  'nullable|in:instagram,snapchat'
        ];
    }
}