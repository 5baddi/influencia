<?php

namespace App\Http\Resources\DataTable;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackerDTResource extends JsonResource
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
            'fulllink'      =>  isset($this->shortlink, $this->shortlink->fulllink) ? $this->shortlink->fulllink : null,
            'influencers'   =>  $this->influencers->map(function($influencer){
                return $influencer->only(['uuid', 'name', 'username', 'pic_url']);
            }),
            'type'          =>  $this->type,
            'platform'      =>  $this->platform ?? null,
            'impressions'   =>  isset($this->analytics, $this->analytics->impressions) ? $this->analytics->impressions : 0,
            'communities'   =>  isset($this->analytics, $this->analytics->communities) ? $this->analytics->communities : 0,
            'engagements'   =>  isset($this->analytics, $this->analytics->engagements) ? $this->analytics->engagements : 0,
            'video_views'   =>  isset($this->analytics, $this->analytics->video_views) ? $this->analytics->video_views : 0,
            'updated_at'    =>  isset($this->analytics, $this->analytics->updated_at) ? $this->analytics->updated_at : $this->updated_at
        ];
    }
}
