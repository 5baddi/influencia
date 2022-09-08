<?php

namespace App\Repositories;

use App\Models\Influencer;
use App\Models\Tracker;

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
       return $this->model->where(['platform' => 'instagram'])
                    ->whereIn('type', ['post', 'story'])
                    ->get();
   }
}
