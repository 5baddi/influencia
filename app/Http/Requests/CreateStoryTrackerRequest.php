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
            'platform'      =>  'nullable|in:instagram,snapchat',
            'username'      =>  'required|string',
            'story'         =>  'required|max:50000|mimetypes:image/jpeg,image/png,image/gif,video/mp4,video/quicktime',
            'nbr_squences'  =>  'nullable|integer',
            'nbr_squences_impressions'          =>  'nullable|integer',
            'nbr_impressions_first_sequence'    =>  'nullable|integer',
            'reach_first_sequence'              =>  'nullable|integer',
            'sticker_taps_mentions'             =>  'nullable|integer',
            'sticker_taps_hashtags'             =>  'nullable|string',
            'link_clicks'                       =>  'nullable|integer',
            'nbr_replies'                       =>  'nullable|integer',
            'nbr_taps_forward'                  =>  'nullable|integer',
            'nbr_taps_backward'                 =>  'nullable|integer',
            'posted_date'                       =>  'nullable|date|date_format:d/m/Y',
            'posted_hour'                       =>  'nullable|integer|min:0,max:23'
        ];
    }
}
