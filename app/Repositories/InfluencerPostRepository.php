<?php

namespace App\Repositories;

use App\Influencer;
use App\InfluencerPost;
use App\InfluencerPostMedia;
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
        // Parse files
        $files = $scraperAttributes['files'];
        unset($scraperAttributes['files']);

        // Add post record
        $post = $this->model->create($scraperAttributes);

        // Add files records to the post
        if(isset($files) && !empty($files))
            $this->addMedias($post, $files);

        return $post->load('files');
    }

    public function update(Model $entity, array $scraperAttributes) : Model
    {
        // Parse files
        $files = $scraperAttributes['files'];
        unset($scraperAttributes['files']);

        // Update post record
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

    /**
     * Add Media for influencer post
     * 
     * @param InfluencerPost $post
     * @param array $mediaFiles
     * @return null|array
     */
    public function addMedias(InfluencerPost $post, array $mediaFiles) : array
    {
        // Init
        $files = [];

        array_walk($mediaFiles, function($file) use ($post, &$files){
            if(empty($file) || is_null($file))
                return;

            // Push added media record
            $file['influencer_post_id'] =  $post->id;
            array_push($files, InfluencerPostMedia::create($file));
        });

        return $files;
    }
}
