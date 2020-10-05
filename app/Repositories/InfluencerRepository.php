<?php

namespace App\Repositories;

use App\Influencer;
use Illuminate\Support\Collection;
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
        return $this->model->create([
            'account_id'    =>  $scraperAttributes['id'],
            'username'      =>  $scraperAttributes['username'],
            'name'          =>  $scraperAttributes['fullName'],
            'pic_url'       =>  $scraperAttributes['profilePicUrlHd'] ?? $scraperAttributes['profilePicUrl'],
            'biography'     =>  $scraperAttributes['biography'],
            'website'       =>  $scraperAttributes['externalUrl'],
            'followers'     =>  $scraperAttributes['followedByCount'],
            'follows'       =>  $scraperAttributes['followsCount'],
            'posts'         =>  $scraperAttributes['mediaCount'],
            'is_business'   =>  $scraperAttributes['isBusinessAccount'],
            'is_private'    =>  $scraperAttributes['isPrivate'],
            'is_verified'   =>  $scraperAttributes['isVerified'],
        ]);
    }

    public function update(Model $entity, array $scraperAttributes) : Model
    {
        $entity->update([
            'account_id'    =>  $scraperAttributes['id'],
            'username'      =>  $scraperAttributes['username'],
            'name'          =>  $scraperAttributes['fullName'],
            'pic_url'       =>  $scraperAttributes['profilePicUrlHd'] ?? $scraperAttributes['profilePicUrl'],
            'biography'     =>  $scraperAttributes['biography'],
            'website'       =>  $scraperAttributes['externalUrl'],
            'followers'     =>  $scraperAttributes['followedByCount'],
            'follows'       =>  $scraperAttributes['followsCount'],
            'posts'         =>  $scraperAttributes['mediaCount'],
            'is_business'   =>  $scraperAttributes['isBusinessAccount'],
            'is_private'    =>  $scraperAttributes['isPrivate'],
            'is_verified'   =>  $scraperAttributes['isVerified'],
        ]);

        return $entity->refresh();
    }
}
