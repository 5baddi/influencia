<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DataTable\InstagramMediaDTResource;

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
        // Init
        $instagramMedia = collect();
        $media = collect();
        $trackers = collect();
        $tags = [];
        $influencers = collect($this->influencers);

        // Collect details about media and tags
        $this->trackers->map(function($tracker) use(&$instagramMedia, &$trackers, &$influencers, &$media, &$tags){
            // Get media type post
            $trackers->add($tracker->only(['uuid', 'type', 'platform', 'name', 'status', 'queued', 'created_at']));

            // Get instagram media
            if($tracker->platform === "instagram"){
                // Load posts
                $tracker->load('posts');
                if($tracker->posts->count() > 0){
                    $instagramMedia = $instagramMedia->merge($tracker->posts);

                    $tracker->posts->load('influencer')->map(function($post) use(&$influencers, &$media, $tracker, &$tags){
                        $_media = collect($post->only(['uuid', 'thumbnail_url', 'type', 'link', 'likes', 'video_views', 'comments']));
                        $_media->put('platform', $tracker->platform);
                        $media->add($_media);

                        // Tags
                        // $tags = array_merge($tags, $post->caption_hashtags);

                        // Set media count by campaign
                        $_influencer = $post->influencer;
                        $influencers = $influencers->map(function($item, $key) use($post, $_influencer){
                            if($item['uuid'] == $_influencer->uuid){
                                // Parse name
                                $item['name'] = preg_replace('/[[:^print:]]/', '', $_influencer->name); // TODO: Improve parsing name

                                // Set number of campaign media
                                if(isset($item['campaign_media']))
                                    $item['campaign_media'] += 1;
                                else
                                    $item['campaign_media'] = 1;

                                // Calculate estimated impressions for all media
                                if(isset($item['campaign_impressions']))
                                    $item['campaign_impressions'] += $post->estimated_impressions;
                                else
                                    $item['campaign_impressions'] = $post->estimated_impressions;
                            }

                            return $item;
                        });
                    });
                }
            }
        });

        return [
            'uuid'                  =>  $this->uuid,
            'name'                  =>  $this->name,
            'communities'           =>  $this->analytics->communities ?? 0,
            'engagements'           =>  $this->analytics->engagements ?? 0,
            'organic_engagements'   =>  $this->analytics->organic_engagements ?? 0,
            'engagement_rate'       =>  $this->analytics->engagement_rate ?? 1,
            'video_views'           =>  $this->analytics->video_views ?? 0,
            'organic_video_views'   =>  $this->analytics->organic_video_views ?? 0,
            'impressions'           =>  $this->analytics->impressions ?? 0,
            'organic_impressions'   =>  $this->analytics->organic_impressions ?? 0,
            'comments_count'        =>  $this->analytics->comments_count ?? 0,
            'top_emojis'            =>  $this->analytics->top_emojis ?? [],
            'sentiments_positive'   =>  $this->analytics->sentiments_positive ?? 0.0,
            'sentiments_neutral'    =>  $this->analytics->sentiments_neutral ?? 0.0,
            'sentiments_negative'   =>  $this->analytics->sentiments_negative ?? 0.0,
            'posts_count'           =>  $this->analytics->posts_count ?? 0.0,
            'organic_posts'         =>  $this->analytics->organic_posts ?? 0.0,
            'stories_count'         =>  $this->analytics->stories_count ?? 0.0,
            'links_count'           =>  $this->analytics->links_count ?? 0.0 ,
            // 'tags'                  =>  collect($tags)->unique()->take(10)->toArray(),
            'updated_at'            =>  isset($this->analytics, $this->analytics->updated_at) ? Carbon::parse($this->analytics->updated_at)->format("Y-m-d H:i") : Carbon::parse($this->updated_at)->format("Y-m-d H:i"),
            'influencers'           =>  $influencers,
            'instagram_media'       =>  InstagramMediaDTResource::collection($instagramMedia),
            'trackers'              =>  $trackers,
            'media'                 =>  $media,
        ];
    }
}
