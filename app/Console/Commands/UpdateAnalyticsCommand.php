<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
use App\TrackerAnalytics;
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

        $this->output->progressFinish();
        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }

    /**
     * Update trackers analytics
     *
     * @return void
     */
    public function trackersAnalytics()
    {
        Tracker::with('posts')->orderBy('created_at', 'desc')->chunk(50, function($trackers){
            $trackers->each(function($tracker){
                // Get exists analytics for today
                $existsAnalytics = TrackerAnalytics::where('tracker_id', $tracker->id)->whereDate('created_at', Carbon::today())->first();
                if(is_null($existsAnalytics)){
                    // Init
                    $analytics = [
                        'tracker_id'            => $tracker->id,
                        'engagements'           => 0,
                        'engagement_rate'       => 0,
                        'communities'           => 0,
                        'impressions'           => 0,
                        'video_views'           => 0,
                        'comments'              => 0,
                        'top_emojis'            => [],
                        'sentiments_positive'   => 0.0,
                        'sentiments_neutral'    => 0.0,
                        'sentiments_negative'   => 0.0,
                    ];

                    // Calculate analytics
                    foreach($tracker->posts->load('influencer') as $post){
                        $analytics['engagements'] += $post->likes + $post->comments;
                        $analytics['communities'] += $post->influencer->followers;
                        $analytics['impressions'] += ($post->likes + $post->comments) * $post->influencer->engagement_rate;
                        $analytics['comments'] += $post->comments;
                        $analytics['video_views'] += $post->video_views;
                        $analytics['sentiments_positive'] += $post->comments_positive;
                        $analytics['sentiments_neutral'] += $post->comments_neutral;
                        $analytics['sentiments_negative'] += $post->comments_negative;

                        if($analytics['impressions'] > 0)
                            $analytics['engagement_rate'] += (($post->likes + $post->comments) / $analytics['impressions']) / 100;

                        // Organic
                        // if(!$post->is_ad){
                        //     $analytics['organic_engagements'] += $post->likes + $post->comments;
                        //     $analytics['organic_video_views'] += $post->video_views;
                        //     $analytics['organic_impressions'] += $post->likes + $post->video_views;
                            
                        //     if($tracker->type === 'post')
                        //         $analytics['organic_posts'] += 1;
                        // }
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
            if(is_null($emojis) || empty($emojis) || $emojis === '')
                continue;

            $topThreeEmojis = array_merge($topThreeEmojis, $emojis);
            $emojisCount += sizeof($emojis);
        }

        // Ignore empty emojis list
        if(is_null($topThreeEmojis) || empty($topThreeEmojis))
            return $topThreeEmojis;

        $topThreeEmojis = array_flip(array_count_values($topThreeEmojis));
        // Sort emojis desc
        krsort($topThreeEmojis);

        // Slice top emojis
        return [
            'top'   =>  array_slice($topThreeEmojis, 0, sizeof($topThreeEmojis) < 3 ? sizeof($topThreeEmojis) : 3, true),
            'all'   =>  $emojisCount
        ];
    }
}
