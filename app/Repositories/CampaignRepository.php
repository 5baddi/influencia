<?php

namespace App\Repositories;

use App\Campaign;

/**
 * Class Campaign Repository.
 *
 * @package namespace App\Repositories;
 */
class CampaignRepository extends BaseRepository
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
       // Init
       $campaigns = $this->model->all();
       $impressions = 0;

       // calculate total estimated impressions
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('post') as $tracker){
                if(is_null($tracker->post))
                    continue;
                    
                $impressions += ($tracker->post->likes + $tracker->post->video_views);
            }
       }

       return $impressions;
   }

   public function getEstimatedCommunities() : int
   {
       // Init 
       $campaigns = $this->model->all();
       $communities = 0;

       // calculate total estimated activated communities
       foreach($campaigns as $campaign){
            if($campaign->trackers->count() === 0)
                continue;

            foreach($campaign->trackers->load('post') as $tracker){
                if(is_null($tracker->post))
                    continue;

                $communities += $tracker->post->comments;
            }
        }

       return $communities;
   }

   /**
     * Get comments analytics of all trackers
     * 
     * @return array
     */
    public function getComments(Campaign $campaign) : array
    {
        // Init
        $comments = ['count' => 0, 'positive' => 0, 'neutral' => 0, 'negative' => 0];
        if($campaign->trackers()->count() === 0)
            return $comments;

        // Calculate comments count
        foreach($campaign->trackers->load('post') as $tracker){
            if(is_null($tracker->post))
                continue;

            $comments['count'] += $tracker->post->comments;
            $comments['positive'] += $tracker->post->comments_positive;
            $comments['neutral'] += $tracker->post->comments_neutral;
            $comments['negative'] += $tracker->post->comments_negative;
        }

        return $comments;
    }
}
