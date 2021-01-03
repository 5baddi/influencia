<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DataTable\InstagramMediaDTResource;

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
        // Load tags
        // $tags = [];
        // $this->posts->map(function($post) use(&$tags){
        //     $tags = array_merge($tags, $post->caption_hashtags);
        // });

        return [
            'uuid'          =>  $this->uuid,
            'name'          =>  $this->name,
            'status'        =>  $this->status,
            'queued'        =>  $this->queued,
            'campaign'      =>  $this->campaign->only(['uuid', 'name']),
            'fulllink'      =>  isset($this->shortlink) ? $this->shortlink->fulllink : null,
            'type'          =>  $this->type,
            'platform'      =>  $this->platform ?? null,
            'updated_at'    =>  isset($this->analytics) ? $this->analytics->updated_at : $this->updated_at,
            // 'tags'          =>  collect($tags)->unique()->take(10)->toArray(),
            'communities'   =>  $this->analytics->communities ?? 0,
            'organic_posts' =>  $this->analytics->organic_posts ?? 0,
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
            'instagram_media'       =>  $this->platform !== 'instagram' ? [] : InstagramMediaDTResource::collection($this->posts),
            'organic_impressions'   =>  $this->analytics->organic_impressions ?? 0,
            'organic_engagements'   =>  $this->analytics->organic_engagements ?? 0,
            'organic_video_views'   =>  $this->analytics->organic_video_views ?? 0,
            'media'                 =>  $this->posts->map(function($post){
                return $post->only(['uuid', 'thumbnail_url', 'type', 'link', 'likes', 'video_views', 'comments']);
            }),
            'influencers'           =>  $this->influencers->map(function($influencer){
                return $influencer->only(['uuid', 'name', 'username', 'pic_url', 'medias', 'estimated_communities', 'estimated_impressions', 'earned_media_value']);
            }),
        ];
    }
}
