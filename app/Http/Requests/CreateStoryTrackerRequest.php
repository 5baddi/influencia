<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
            'campaign_id'   =>  'required|integer|exists:campaigns,id',
            'name'          =>  'required|unique:trackers,name|max:255',
            'type'          =>  'required|in:story',
            'platform'      =>  'nullable|in:instagram,snapchat',
            'username'      =>  'required|string',
            'thumbnail'     =>  'required|max:50000|mimetypes:image/jpeg,image/png,image/gif',
            'story'         =>  'nullable|max:50000|mimetypes:video/mp4,video/quicktime',
            'proofs.*'      =>  'nullable|max:50000|mimetypes:image/jpeg,image/png,image/gif',
            'reach'         =>  'nullable|integer',
            'impressions'   =>  'nullable|integer',
            'interactions'  =>  'nullable|integer',
            'back'          =>  'nullable|integer',
            'forward'       =>  'nullable|integer',
            'next_story'    =>  'nullable|integer',
            'exited'        =>  'nullable|integer',
            'published_at'  =>  'nullable|date',
        ];
    }
}
