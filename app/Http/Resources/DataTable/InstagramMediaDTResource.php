<?php

namespace App\Http\Resources\DataTable;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InstagramMediaDTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'link'                      =>  $this->link, 
            'caption'                   =>  $this->caption, 
            'type'                      =>  $this->type, 
            'comments'                  =>  $this->comments, 
            'influencer'                =>  $this->influencer->only(['uuid', 'name', 'username', 'pic_url']),
            'activated_communities'     =>  $this->activated_communities, 
            'estimated_impressions'     =>  $this->estimated_impressions, 
            'engagements'               =>  $this->engagements, 
            'organic_impressions'       =>  $this->organic_impressions, 
            'video_views'               =>  $this->video_views,
            'likes'                     =>  $this->likes, 
            'published_at'              =>  Carbon::parse($this->published_at)->format('Y-m-d H:i'), 
            'earned_media_value'        =>  $this->earned_media_value
        ];
    }
}
