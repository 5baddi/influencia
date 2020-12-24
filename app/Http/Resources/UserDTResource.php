<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDTResource extends JsonResource
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
            'email'             =>  $this->email,
            'role_name'         =>  $this->is_superadmin ? "Super Admin" : $this->role->name,
            'brands'            =>  BrandDTResource::collection($this->brands),
            'last_login'        =>  $this->last_login,
            'created_at'        =>  $this->created_at,
        ];
    }
}
