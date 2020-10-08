<?php

namespace App\Repositories;

use App\Influencer;
use App\InfluencerPost;
use App\Tracker;
use Illuminate\Support\Collection;
use Format;

/**
 * Class TrackerRepository.
 *
 * @package namespace App\Repositories;
 */
class TrackerRepository extends BaseRepository
{
    /**
    * Influencer Post Repository constructor.
    *
    * @param Tracker $model
    */
   public function __construct(Tracker $model)
   {
       parent::__construct($model);
   }

   /**
    * Get only instagram trackers
    *
    * @return Collection
    */
   public function getInstagram() : Collection
   {
       return $this->model->where(['platform' => 'instagram', 'status' => true])
                    ->whereIn('type', ['post', 'story'])
                    ->get();
   }

   public function getNomberOfReplies(Tracker $entity) : int
    {
        // Parse short code
        $shortCode = Format::extractInstagarmShortCode($entity->url);

        // Get influencer ID
        $influencer = Influencer::where('username', $entity->username)->first();

        if(is_null($shortCode) || is_null($influencer))
            return 0;

        // Get Post
        $post = InfluencerPost::where(['influencer_id' => $influencer->id, 'short_code' => $shortCode])->first();
        if(is_null($post))
            return 0;

        return $post->comments;
    }
}
