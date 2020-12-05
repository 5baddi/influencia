<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
use App\TrackerInfluencerMedia;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;

class InfluencersUpdaterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:influencers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update influencers media';

    /**
     * Instagram scraper
     * 
     * @var \App\Services\InstagramScraper
     */
    private $instagram;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InstagramScraper $instagram)
    {
        parent::__construct();

        // Init
        $this->instagram = $instagram;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Init scraper
        $this->instagram = $this->instagram->authenticate();
        
        $this->info("=== Start updating influencers ===");
        $startTaskAt = microtime(true);

        // Init 
        $ignoreInstagram = false;

        try{
            // Load all influencers
            $influencers = Influencer::with(['posts'])->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get();
            $this->info("Influencers need update {$influencers->count()}");

            foreach($influencers as $influencer){
                // Ignore still in scraping queue
                if($influencer->posts->count() !== $influencer->medias)
                    continue;

                // Update instagram media
                if($influencer->platform === 'instagram' && !$ignoreInstagram){
                    // Break process if last one executed less than 10 minutes
                    if($influencer->updated_at->diffInMinutes(Carbon::now()->subMinutes(10)) === 0){
                        $ignoreInstagram = true;
                        continue;
                    }
                        
                    $this->info("Update Instagram influencer @{$influencer->username}");
                    
                    foreach($influencer->posts as $post){
                        try{
                            // Get online media
                            $media = $this->instagram->getMedia($post->short_code);
                            $this->info("Post {$media['short_code']} successfully scraped!");

                            // Update comments if post linked to a tracker
                            $mediaTrackersCount = TrackerInfluencerMedia::where('influencer_post_id', $influencerMedia->id)->count();
                            if($mediaTrackersCount > 0){
                                $sentiments = $this->instagram->analyzeMedia($media);
                                $media = array_merge($media, $sentiments);
                            }

                            // Update local media
                            $files = $media['files'];
                            unset($media['files']);
                            $post->update($media);

                            // Update media assets
                            array_walk($files, function($file) use ($post){
                                if(empty($file) || is_null($file) || !is_array($file))
                                    return;
                    
                                // Push added media record
                                $file = array_merge($file, ['post_id' =>  $post->id]);
                                InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file);
                            });

                            $this->info("Post {$post->short_code} successfully updated.");
                        }catch(\Exception $ex){
                            $this->error($ex->getMessage());

                            // Break process if reach the Instagram limit
                            if($ex->getCode() === 111)
                                break;
                        }
                    }
                }
            }

            $this->info("=== Done ===");
            $endTaskAt = microtime(true) - $startTaskAt;
            $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());

            return 1;
        }catch(\Exception $exception){
            $this->error($exception->getMessage());

            return 0;
        }
    }
}
