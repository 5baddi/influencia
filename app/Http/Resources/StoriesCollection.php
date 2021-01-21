<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoriesCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'                  =>  $this->uuid,
            'story_id'              =>  $this->story_id,
            'type'                  =>  $this->type,
            'thumbnail'             =>  $this->thumbnail,
            // 'video'                 =>  $this->video,
            'video_duration'        =>  $this->video_duration,
            'link'                  =>  $this->link,
            'published_at'          =>  $this->published_at,
            'influencer'            =>  $this->influencer->only(['uuid', 'parsed_name', 'username', 'pic_url', 'platform']),
            'tracker'               =>  !is_null($this->tracker) ? $this->tracker->only(['uuid', 'queued', 'updated_at', 'status']) : null,
        ];
    }
}
