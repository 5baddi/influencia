<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandDTResource extends JsonResource
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
            'public_logo'       =>  $this->public_logo,
            'users'             =>  $this->users->map(function($user){
                return $user->only(['uuid', 'name']);
            }),
            'users_count'       =>  $this->users_count,
            'campaigns_count'   =>  $this->campaigns_count,
            'trackers_count'    =>  $this->trackers_count,
            'created_at'        =>  $this->created_at
        ];
    }
}
