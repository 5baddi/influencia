<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasUuidRouteKey;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_login',
        'selected_brand_id',
        'is_superadmin',
        'banned'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:i',
        'last_login'        => 'datetime:Y-m-d H:i',
        'created_at'        => 'datetime:Y-m-d H:i',
        'updated_at'        => 'datetime:Y-m-d H:i',
        'is_superadmin'     => 'boolean',
        'banned'            => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function selectedBrand()
    {
        return $this->belongsTo(Brand::class, 'selected_brand_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_user');
    }

    public function campaigns()
    {
        return $this->hasMany(campaign::class);
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function influencers()
    {
        $influencers = collect();

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts->load('influencer') as $post){
                if($influencers->contains('id', $post->influencer->id))
                    continue;

                $influencers->add($post->influencer);
            }
        }

        return $influencers;
    }
}
