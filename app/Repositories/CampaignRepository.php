<?php

namespace App\Repositories;

use App\Campaign;
use Illuminate\Support\Collection;

/**
 * Class Campaign Repository.
 *
 * @package namespace App\Repositories;
 */
class TrackerRepository extends BaseRepository
{
    /**
    * Campaign Repository constructor.
    *
    * @param Campaign $model
    */
   public function __construct(Campaign $model)
   {
       parent::__construct($model);
   }

   public function getEstimatedImpressions() : int
   {
       $campaigns = $this->model->all();
       // TODO: calculate total estimated impressions
   }
}
