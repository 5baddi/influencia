<?php

namespace App\Console\Commands;

use App\Tracker;
use App\Campaign;
use Carbon\Carbon;
use App\TrackerAnalytics;
use App\CampaignAnalytics;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UpdateAnalyticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update analytics for trackers & campaigns';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Init start at time
        $startTaskAt = microtime(true);
        $this->info("=== Start update analytics ===");
        $this->output->progressStart(1);

        // Update trackers analytics
        $this->trackersAnalytics();

        // Update campaigns analytics
        $this->campaignsAnalytics();

        $this->output->progressFinish();
        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }

    /**
     * Update campaigns analytics
     *
     * @return void
     */
    private function campaignsAnalytics()
    {
        Campaign::with('trackers')->orderBy('created_at', 'desc')->chunk(50, function($campaigns){
            $campaigns->each(function($campaign){
                // Get exists analytics for today
                $existsAnalytics = CampaignAnalytics::where('campaign_id', $campaign->id)->whereDate('created_at', Carbon::today())->first();
                if(is_null($existsAnalytics)){
                    // Init
                    $analytics = [
                        'campaign_id'           => $campaign->id,
                        'engagements'           => 0,
                        'organic_engagements'   => 0,
                        'engagement_rate'       => 0,
                        'communities'           => 0,
                        'impressions'           => 0,
                        'organic_impressions'   => 0,
                        'video_views'           => 0,
                        'organic_video_views'   => 0,
                        'comments_count'        => 0,
                        'posts_count'           => 0,
                        'organic_posts'         => 0,
                        'stories_count'         => 0,
                        'links_count'           => 0,
                        'top_emojis'            => [
                            'top'               => [],
                            'all'               => 0
                        ],
                        'sentiments_positive'   => 0.0,
                        'sentiments_neutral'    => 0.0,
                        'sentiments_negative'   => 0.0,
                    ];

                    // Calculate analytics
                    foreach($campaign->trackers->load('analytics') as $tracker){
                        if($tracker->queued !== 'finished' || is_null($tracker->analytics))
                            continue;

                        $analytics['engagements'] += $tracker->analytics->engagements;
                        $analytics['communities'] += $tracker->analytics->communities;
                        $analytics['impressions'] += $tracker->analytics->impressions;
                        $analytics['comments_count'] += $tracker->analytics->comments;
                        $analytics['video_views'] += $tracker->analytics->video_views;
                        $analytics['sentiments_positive'] += $tracker->analytics->comments_positive;
                        $analytics['sentiments_neutral'] += $tracker->analytics->comments_neutral;
                        $analytics['sentiments_negative'] += $tracker->analytics->comments_negative;
                        $analytics['posts_count'] += $tracker->analytics->posts_count;

                        // Engagement rate
                        if($analytics['impressions'] > 0)
                            $analytics['engagement_rate'] += $tracker->analytics->engagement_rate;

                        // Organic
                        if(!is_null($tracker->analytics->organic_engagements))
                            $analytics['organic_engagements'] += $tracker->analytics->organic_engagements;
                        if(!is_null($tracker->analytics->organic_video_views))
                            $analytics['organic_video_views'] += $tracker->analytics->organic_video_views;
                        if(!is_null($tracker->analytics->organic_video_views))
                            $analytics['organic_impressions'] += $tracker->analytics->organic_impressions;
                        if(!is_null($tracker->analytics->organic_video_views))
                            $analytics['organic_posts'] += $tracker->analytics->organic_posts;

                        // Emojis
                        if(isset($tracker->analytics->top_emojis['top'], $tracker->analytics->top_emojis['all'])){
                            $analytics['top_emojis']['top'] = array_merge($analytics['top_emojis']['top'], $tracker->analytics->top_emojis['top']);
                            $analytics['top_emojis']['all'] += $tracker->analytics->top_emojis['all'];
                        }
                    }
                    
                    // Get top emojis
                    if(isset($analytics['top_emojis']['top']) && sizeof($analytics['top_emojis']['top']) > 1){
                        $analytics['top_emojis']['top'] =  array_slice($analytics['top_emojis']['top'], 0, sizeof($analytics['top_emojis']['top']) < 3 ? sizeof($analytics['top_emojis']['top']) : 3, true);
                        $topThreeEmojis = array_flip($analytics['top_emojis']['top']);
                        // Sort emojis desc
                        krsort($topThreeEmojis);
                        $topThreeEmojis = array_flip($topThreeEmojis);
                        $analytics['top_emojis']['top'] = $topThreeEmojis;
                    }

                    // Save the analytics
                    CampaignAnalytics::create($analytics);
                }

                $this->output->progressAdvance();
            });
        });
    }

    /**
     * Update trackers analytics
     *
     * @return void
     */
    private function trackersAnalytics()
    {
        Tracker::with('posts')->where('queued', 'finished')->orderBy('created_at', 'desc')->chunk(50, function($trackers){
            $trackers->each(function($tracker){
                // Get exists analytics for today
                $existsAnalytics = TrackerAnalytics::where('tracker_id', $tracker->id)->whereDate('created_at', Carbon::today())->first();
                if(is_null($existsAnalytics)){
                    // Init
                    $analytics = [
                        'tracker_id'            => $tracker->id,
                        'engagements'           => 0,
                        'organic_engagements'   => 0,
                        'engagement_rate'       => 0,
                        'communities'           => 0,
                        'impressions'           => 0,
                        'organic_impressions'   => 0,
                        'video_views'           => 0,
                        'organic_video_views'   => 0,
                        'comments_count'        => 0,
                        'posts_count'           => 0,
                        'organic_posts'         => 0,
                        'top_emojis'            => [],
                        'sentiments_positive'   => 0.0,
                        'sentiments_neutral'    => 0.0,
                        'sentiments_negative'   => 0.0,
                    ];

                    // Save tracker posts count
                    switch($tracker->type){
                        case "post":
                            $analytics['posts_count'] = $tracker->posts->count();
                        break;
                    }

                    // Calculate analytics
                    foreach($tracker->posts->load('influencer') as $post){
                        $analytics['engagements'] += $post->likes + $post->comments;
                        $analytics['communities'] += $post->influencer->followers;
                        $analytics['impressions'] += ($post->likes + $post->comments) * $post->influencer->engagement_rate;
                        $analytics['comments_count'] += $post->comments;
                        $analytics['video_views'] += $post->video_views;
                        $analytics['sentiments_positive'] += $post->comments_positive;
                        $analytics['sentiments_neutral'] += $post->comments_neutral;
                        $analytics['sentiments_negative'] += $post->comments_negative;

                        if($analytics['impressions'] > 0)
                            $analytics['engagement_rate'] += (($post->likes + $post->comments) / $analytics['impressions']) / 100;

                        // Organic
                        if(!$post->is_ad){
                            $analytics['organic_engagements'] += $post->likes + $post->comments;
                            $analytics['organic_video_views'] += $post->video_views;
                            $analytics['organic_impressions'] += $post->likes + $post->video_views;
                            
                            if($tracker->type === 'post')
                                $analytics['organic_posts'] = $analytics['organic_posts'] + 1;
                        }
                    }

                    // Re-calculate sentiments
                    $analytics['sentiments_positive'] = $tracker->posts->count() > 0 ? $analytics['sentiments_positive'] / $tracker->posts->count() : 0.0;
                    $analytics['sentiments_neutral'] = $tracker->posts->count() > 0 ? $analytics['sentiments_neutral'] / $tracker->posts->count() : 0.0;
                    $analytics['sentiments_negative'] = $tracker->posts->count() > 0 ? $analytics['sentiments_negative'] / $tracker->posts->count() : 0.0;

                    // Get top emojis
                    $analytics['top_emojis'] = $this->getTopThreeEmojis($tracker->posts);

                    // Save the analytics
                    TrackerAnalytics::create($analytics);
                }

                $this->output->progressAdvance();
            });
        });
    }

    /**
     * Get top three emojis
     *
     * @param \App\InfleuncerPosts[] $post
     * @return array
     */
    private function getTopThreeEmojis(Collection $posts){
        $topThreeEmojis = [];
        $emojisCount = 0;

        foreach($posts as $post){
            $emojis = json_decode(json_encode($post->comments_emojis), true);
            // Ignore if no result
            if(is_null($emojis) || empty($emojis) || $emojis == '')
                continue;

            // Ignore empty emojis
            array_walk($emojis, function($value, $key){
                $value = trim($value);
                if(empty($value) || is_null($value) || $value == '')
                    unset($emojis[$key]);
            });

            $topThreeEmojis = array_merge($topThreeEmojis, $emojis);
            $emojisCount += sizeof($emojis);
        }

        // Ignore empty emojis list
        if(is_null($topThreeEmojis) || empty($topThreeEmojis))
            return $topThreeEmojis;

        $topThreeEmojis = array_flip(array_count_values($topThreeEmojis));
        // Sort emojis desc
        krsort($topThreeEmojis);
        $topThreeEmojis = array_flip($topThreeEmojis);

        // Slice top emojis
        return [
            'top'   =>  array_slice($topThreeEmojis, 0, sizeof($topThreeEmojis) < 3 ? sizeof($topThreeEmojis) : 3, true),
            'all'   =>  $emojisCount
        ];
    }
}
