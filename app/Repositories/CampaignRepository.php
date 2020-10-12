<?php

namespace App\Repositories;

use App\Campaign;
use Illuminate\Support\Collection;

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
            foreach($campaign->trackers->load('posts') as $tracker){
                $tracker->posts->sum(function($item) use (&$impressions){
                    $impressions += ($item->likes + $item->video_views);
                });
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
        foreach($campaign->trackers->load('posts') as $tracker){
            $tracker->posts->sum(function($item) use (&$communities){
                $communities += $item->comments;
            });
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
        foreach($campaign->trackers->load('posts') as $tracker){
            $tracker->posts->sum(function($item) use (&$comments){
                $comments['count'] += $item->comments;
                $comments['positive'] += $item->comments_positive;
                $comments['neutral'] += $item->comments_neutral;
                $comments['negative'] += $item->comments_negative;
            });
        }

        // Reforme calcul
        if(sizeof($comments) > 0){
            $comments['positive'] = $comments['positive'] / sizeof($comments);
            $comments['neutral'] = $comments['neutral'] / sizeof($comments);
            $comments['negative'] = $comments['negative'] / sizeof($comments);
        }

        return $comments;
    }
}
