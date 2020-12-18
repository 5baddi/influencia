<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', $this->request->get('campaign_id')) || Gate::allows('create_tracker');
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
            'type'          =>  'required|in:url,post',
            'url'           =>  'required|url',
            'platform'      =>  'nullable|in:instagram,youtube,snapchat',
        ];
    }
}
