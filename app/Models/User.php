<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'banned',
        'avatar'
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'influencers'
    ];

    /**
     * Encrypt plain text password
     *
     * @param string $value
     * @return self
     */
    public function setPasswordAttribute(string $value) : self
    {
        $this->attributes['password'] = Hash::make($value);

        return $this;
    }

    /**
     * Get user avatar as base64
     * 
     * @return string|null
     */
    public function getAvatarAttribute() : ?string
    {
        if(isset($this->attributes['avatar']))
            return "data:image/png;base64," . base64_encode(Storage::disk('local')->get($this->attributes['avatar']));

        return null;
    }

    public function selectedBrand()
    {
        return $this->belongsTo(Brand::class, 'selected_brand_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_users');
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

    public function getInfluencersAttribute()
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
