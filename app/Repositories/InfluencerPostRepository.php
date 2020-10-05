<?php

namespace App\Repositories;

use App\Influencer;
use App\InfluencerPost;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InfluencerRepository.
 *
 * @package namespace App\Repositories;
 */
class InfluencerPostRepository extends BaseRepository
{
    /**
    * Influencer Post Repository constructor.
    *
    * @param InfluencerPost $model
    */
   public function __construct(InfluencerPost $model)
   {
       parent::__construct($model);
   }

   /**
    * Create new Influencer Post
    *
    * @param array $scraperAttributes
    * @return Model
    */
    public function create(array $scraperAttributes) : Model
    {
        return $this->model->create($scraperAttributes);
    }

    public function update(Model $entity, array $scraperAttributes) : Model
    {
        $entity->update($scraperAttributes);

        return $entity->refresh();
    }

    public function exists(Influencer $influencer, int $postID) : ?InfluencerPost
    {
        // Get exists row
        $existsRow = InfluencerPost::where(['influencer_id' => $influencer->id, 'post_id' => $postID])->first();
        if(!is_null($existsRow))
            return $existsRow;

        return null;
    }
}
