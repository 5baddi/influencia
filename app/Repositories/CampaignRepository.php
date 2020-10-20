<?php

namespace App\Repositories;

use App\Campaign;
use Illuminate\Support\Facades\Auth;

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

   public function getEngagements() : int
   {
       // Init
       $campaigns = $this->model->all();
       $engagements = 0;

       // calculate total estimated impressions
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;

                foreach($tracker->posts as $post){
                    $engagements += $post->likes + $post->comments;
                }
            }
       }

       return $engagements;
   }

   public function getOrganicEngagements() : int
   {
       // Init
       $campaigns = $this->model->all();
       $engagements = 0;

       // calculate total estimated engagements
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;

                foreach($tracker->posts as $post){
                    if($post->is_ad)
                        continue;

                    $engagements += $post->likes + $post->comments;
                }
            }
       }

       return $engagements;
   }
   
   public function getViews() : int
   {
       // Init
       $campaigns = $this->model->all();
       $views = 0;

       // calculate total estimated impressions
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;
                    
                foreach($tracker->posts as $post){
                    $views += $post->video_views;
                }
            }
       }

       return $views;
   }

   public function getOrganicViews() : int
   {
       // Init
       $campaigns = $this->model->all();
       $views = 0;

       // calculate total estimated views
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;

                foreach($tracker->posts as $post){
                    if($post->is_ad)
                        continue;

                    $views += $post->video_views;
                }
            }
       }

       return $views;
   }
   
   public function getEstimatedImpressions() : int
   {
       // Init
       $campaigns = $this->model->all();
       $impressions = 0;

       // calculate total estimated impressions
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;

                foreach($tracker->posts as $post){
                    $impressions += ($post->likes + $post->video_views);
                }
            }
       }

       return $impressions;
   }
   
   public function getEstimatedOrganicImpressions() : int
   {
       // Init
       $campaigns = $this->model->all();
       $impressions = 0;

       // calculate total estimated impressions
       foreach($campaigns as $campaign){
            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts))
                    continue;

                foreach($tracker->posts as $post){
                    if($post->is_ad)
                        continue;

                    $impressions += ($post->likes + $post->video_views);
                }
            }
       }

       return $impressions;
   }

   public function getEstimatedCommunities() : int
   {
       // Init 
       $communities = 0;
       $campaigns = $this->selectedBrandCampaigns();
        if(!$campaigns)
            return $communities;

       // calculate total estimated activated communities
       foreach($campaigns as $campaign){
            if($campaign->trackers->count() === 0)
                continue;

            foreach($campaign->trackers->load('post') as $tracker){
                if(is_null($tracker->posts) || !in_array($tracker->type, ['post', 'story']))
                    continue;

                foreach($tracker->posts as $post){
                    // Load influencer
                    $post->load('influencer');

                    $communities += $post->influencer->followers;   
                }

                // switch($tracker->type){
                //     case 'post':
                //         $communities += $tracker->post->comments;
                //     break;
                //     case 'story':
                //         $communities += $tracker->nbr_replies;
                //     break;
                // }
            }
        }

       return $communities;
   }
   
   public function getEstimatedOrganicCommunities() : int
   {
       // Init 
       $communities = 0;
       $campaigns = $this->selectedBrandCampaigns();
        if(!$campaigns)
            return $communities;

       // calculate total estimated activated communities
       foreach($campaigns as $campaign){
            if($campaign->trackers->count() === 0)
                continue;

            foreach($campaign->trackers->load('posts') as $tracker){
                if(is_null($tracker->posts) || !in_array($tracker->type, ['post', 'story']))
                    continue;

                foreach($tracker->posts as $post){
                    if($post->is_ad)
                        continue;
                        
                    // Load influencer
                    $post->load('influencer');

                    $communities += $post->influencer->followers;   
                }
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

    private function selectedBrandCampaigns()
    {
        if(!Auth::check())
            return null;

        // Load data
        $brand = Auth::user()->selectedBrand->load('campaigns');

        return $brand->campaigns();
    }
}
