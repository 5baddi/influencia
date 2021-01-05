<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class InfluencerStory extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'influencer_stories';

    /**
     * Get story analytics
     *
     * @return \App\StoryAnalytics
     */
    public function analytics()
    {
        return $this->hasOne(StoryAnalytics::class, 'story_id', 'story_id')->latest();
    }

    /**
     * Get story thumbnail as base64
     * 
     * @return string|null
     */
    public function getThumbnailAttribute() : ?string
    {
        if(isset($this->attributes['thumbnail'])){
            // External link
            if(filter_var($this->attributes['thumbnail'], FILTER_VALIDATE_URL))
                return $this->attributes['thumbnail'];

            // Picture as base64
            return "data:image/png;base64," . base64_encode(Storage::disk('local')->get($this->attributes['thumbnail']));
        }

        return null;
    }

    /**
     * Get video link
     *
     * @return string|null
     */
    public function getVideoAttribute(): ?string
    {
        if(isset($this->attributes['video'])){
            return Storgae::disk('local')->url($this->attributes['video']);
        }

        return null;
    }
}
