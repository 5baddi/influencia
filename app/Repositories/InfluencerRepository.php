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
        // Parse data
        $parsedData = [
            'account_id'    =>  $scraperAttributes['id'],
            'username'      =>  $scraperAttributes['username'],
            'name'          =>  $scraperAttributes['fullName'],
            'pic_url'       =>  ($scraperAttributes['profilePicUrlHd'] !== '') ? $scraperAttributes['profilePicUrlHd'] : $scraperAttributes['profilePicUrl'],
            'biography'     =>  $scraperAttributes['biography'],
            'website'       =>  $scraperAttributes['externalUrl'],
            'followers'     =>  $scraperAttributes['followedByCount'],
            'follows'       =>  $scraperAttributes['followsCount'],
            'posts'         =>  $scraperAttributes['mediaCount'],
            'is_business'   =>  $scraperAttributes['isBusinessAccount'],
            'is_private'    =>  $scraperAttributes['isPrivate'],
            'is_verified'   =>  $scraperAttributes['isVerified'],
            'highlight_reel'    =>  $scraperAttributes['highlightReelCount'],
            'business_category' =>  $scraperAttributes['businessCategoryName'],
            'business_email'    =>  $scraperAttributes['businessEmail'],
            'business_phone'    =>  $scraperAttributes['businessPhoneNumber'],
            'business_address'  =>  $scraperAttributes['businessAddressJson'],
        ];

        return $this->model->create($parsedData);
    }

    public function update(Model $entity, array $scraperAttributes) : Model
    {
        // Parse data
        $parsedData = [
            'account_id'    =>  $scraperAttributes['id'],
            'username'      =>  $scraperAttributes['username'],
            'name'          =>  $scraperAttributes['fullName'],
            'pic_url'       =>  ($scraperAttributes['profilePicUrlHd'] !== '') ? $scraperAttributes['profilePicUrlHd'] : $scraperAttributes['profilePicUrl'],
            'biography'     =>  $scraperAttributes['biography'],
            'website'       =>  $scraperAttributes['externalUrl'],
            'followers'     =>  $scraperAttributes['followedByCount'],
            'follows'       =>  $scraperAttributes['followsCount'],
            'posts'         =>  $scraperAttributes['mediaCount'],
            'is_business'   =>  $scraperAttributes['isBusinessAccount'],
            'is_private'    =>  $scraperAttributes['isPrivate'],
            'is_verified'   =>  $scraperAttributes['isVerified'],
            'highlight_reel'    =>  $scraperAttributes['highlightReelCount'],
            'business_category' =>  $scraperAttributes['businessCategoryName'],
            'business_email'    =>  $scraperAttributes['businessEmail'],
            'business_phone'    =>  $scraperAttributes['businessPhoneNumber'],
            'business_address'  =>  $scraperAttributes['businessAddressJson'],
        ];

        $entity->update($parsedData);

        return $entity->refresh();
    }
}
