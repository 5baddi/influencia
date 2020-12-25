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
            'uuid'              =>  $this->uuid,
            'name'              =>  $this->name,
            'status'            =>  $this->status,
            'communities'       =>  isset($this->analytics) ? $this->analytics->communities : 0,
            'influencers'       =>  $this->influencers,
            'trackers_count'    =>  $this->trackers_count ?? 0,
            'updated_at'        =>  isset($this->analytics) ? $this->analytics->updated_at : $this->updated_at
        ];
    }
}
