<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackerAnalyticsResource extends JsonResource
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
            'uuid'          =>  $this->uuid,
            'name'          =>  $this->name,
            'status'        =>  $this->status,
            'queued'        =>  $this->queued,
            'campaign_name' =>  $this->campaign->name,
            'fulllink'      =>  isset($this->shortlink) ? $this->shortlink->fulllink : null,
            'influencers'   =>  $this->influencers->map(function($influencer){
                return $influencer->only(['uuid', 'name', 'username', 'pic_url', 'posts', 'estimated_communities', 'estimated_impressions', 'earned_media_value']);
            }),
            'type'          =>  $this->type,
            'platform'      =>  $this->platform ?? null,
            'updated_at'    =>  isset($this->analytics) ? $this->analytics->updated_at : $this->updated_at,
            'communities'   =>  $this->analytics->communities ?? 0,
            'impressions'   =>  $this->analytics->impressions ?? 0,
            'video_views'   =>  $this->analytics->video_views ?? 0,
            'engagements'   =>  $this->analytics->engagements ?? 0,
            'posts_count'   =>  $this->analytics->posts_count ?? 0,
            'comments_count'   =>  $this->analytics->comments_count ?? 0,
            'engagement_rate'  =>  $this->analytics->engagement_rate ?? 0,
            'top_emojis'       =>  $this->analytics->top_emojis ?? [],
            'sentiments_positive'   =>  $this->analytics->sentiments_positive ?? 0.0,
            'sentiments_neutral'    =>  $this->analytics->sentiments_neutral ?? 0.0,
            'sentiments_negative'   =>  $this->analytics->sentiments_negative ?? 0.0,
            'instagram_posts'       =>  $this->platform !== 'instagram' ? [] : $this->posts->map(function($instaMedia){
                return $instaMedia->only([
                    'link', 'caption', 'type', 'comments', 'influencer.pic_url', 'influencer.name', 'influencer.username',
                    'activated_communities', 'estimated_impressions', 'engagements', 'organic_impressions', 'video_views',
                    'likes', 'published_at', 'earned_media_value'
                ]);
            }),
        ];
    }
}
