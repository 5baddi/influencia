<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'is_superadmin'     =>  $this->is_superadmin,
            'selected_brand_id' =>  $this->selected_brand_id,
            'selected_brand'    =>  new BrandResource($this->selected_brand),
            'role'              =>  new RoleResource($this->role),
            'banned'            =>  $this->banned,
            'last_login'        =>  $this->last_login,
            'created_at'        =>  $this->created_at
        ];
    }
}
