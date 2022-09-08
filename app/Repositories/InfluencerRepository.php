<?php

namespace App\Repositories;

use App\Models\Influencer;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InfluencerRepository.
 *
 * @package namespace App\Repositories;
 */
class InfluencerRepository extends BaseRepository
{
    /**
    * Influencer Repository constructor.
    *
    * @param Influencer $model
    */
   public function __construct(Influencer $model)
   {
       parent::__construct($model);
   }

   /**
    * Get all usernames
    *
    * @return array
    */
   public function getUsernames() : array
   {
       return $this->model->pluck('username', 'id')->toArray();
   }

   /**
    * Create new influencer
    *
    * @param array $scraperAttributes
    * @return Model
    */
    public function create(array $scraperAttributes) : Model
    {
        // Create new row
        return $this->model->create($scraperAttributes);
    }

    public function update(Model $entity, array $scraperAttributes) : Model
    {
        // Update row
        $entity->update($scraperAttributes);

        return $entity->refresh();
    }
}
