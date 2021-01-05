<?php

namespace App\Http\Resources\DataTable;

use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerDTResource extends JsonResource
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
            'name'          =>  preg_replace('/[[:^print:]]/', '', $this->name),
            'username'      =>  $this->username,
            'platform'      =>  $this->platform,
            'pic_url'       =>  $this->pic_url,
            'account_id'    =>  $this->account_id,
            'followers'     =>  $this->followers,
            'medias'        =>  $this->medias,
            'posts_count'   =>  $this->posts_count,
            'updated_at'    =>  $this->updated_at,
            'engagement_rate'  =>  $this->engagement_rate,
            'trackers_count'   =>  $this->trackers_count,
        ];
    }
}
