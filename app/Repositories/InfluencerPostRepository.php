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
     * Current fetched record
     * 
     * @var InfluencerPost
     */
    public $entity = null;

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
        $files = isset($scraperAttributes['files']) ? $scraperAttributes['files'] : [];
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
        $files = isset($scraperAttributes['files']) ? $scraperAttributes['files'] : [];
        unset($scraperAttributes['files']);

        // Update post record
        $entity->update($scraperAttributes);

        // Add and update files records to the post
        if(isset($files) && !empty($files))
            $this->addMedias($entity, $files);

        return $entity->load('files')->refresh();
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
            if(empty($file) || is_null($file) || !is_array($file))
                return;

            // Push added media record
            $file = array_merge($file, ['post_id' =>  $post->id]);
            array_push($files, InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file));
        });

        return $files;
    }

    public function getEntity(string $username, string $link) : ?InfluencerPost
    {
        // Parse short code
        $shortCode = Format::extractInstagarmShortCode($link);
        if(is_null($shortCode))
            return null;

        return InfluencerPost::whereHas('influencer', function($influencer) use ($username){
                    $influencer->where('username', $username);
                })
                ->where('short_code', $shortCode)
                ->first();
    }

    public function getNumberOfReplies() : int
    {
        return !is_null($this->entity) ? $this->entity->comments : 0;
    }
    
    public function getNumberOfSequences() : int
    {
        if(is_null($this->entity))
            return 0;

        dd($this->entity->withCount('files')->get());
    }
}
