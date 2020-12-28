<?php

namespace App\Http\Resources\DataTable;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignDTResource extends JsonResource
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
            'id'                =>  $this->id,
            'uuid'              =>  $this->uuid,
            'name'              =>  $this->name,
            'status'            =>  $this->status,
            'impressions'       =>  isset($this->analytics, $this->analytics->impressions) ? $this->analytics->impressions : 0,
            'communities'       =>  isset($this->analytics, $this->analytics->communities) ? $this->analytics->communities : 0,
            'engagements'       =>  isset($this->analytics, $this->analytics->engagements) ? $this->analytics->engagements : 0,
            'video_views'       =>  isset($this->analytics, $this->analytics->video_views) ? $this->analytics->video_views : 0,
            'engagement_rate'   =>  isset($this->analytics, $this->analytics->engagement_rate) ? $this->analytics->engagement_rate : 0,
            'influencers'       =>  $this->influencers,
            'trackers_count'    =>  $this->trackers_count ?? 0,
            'updated_at'        =>  isset($this->analytics,  $this->analytics->updated_at) ? $this->analytics->updated_at : $this->updated_at
        ];
    }
}
