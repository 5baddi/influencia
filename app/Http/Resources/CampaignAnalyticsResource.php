<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignAnalyticsResource extends JsonResource
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
            'communities'           =>  $this->communities,
            'engagements'           =>  $this->engagements,
            'engagement_rate'       =>  $this->engagement_rate,
            'video_views'           =>  $this->video_views,
            'impressions'           =>  $this->impressions,
            'comments_count'        =>  $this->comments_count,
            'top_emojis'            =>  $this->top_emojis,
            'sentiments_positive'   =>  $this->sentiments_positive,
            'sentiments_neutral'    =>  $this->sentiments_neutral,
            'sentiments_negative'   =>  $this->sentiments_negative,
            'posts_count'           =>  $this->posts_count,
            'stories_count'         =>  $this->stories_count,
            'links_count'           =>  $this->links_count,
            'updated_at'            =>  $this->updated_at,
        ];
    }
}
