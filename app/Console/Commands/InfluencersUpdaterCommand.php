<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;

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
        $this->info("=== Start updating influencers ===");
        $startTaskAt = microtime(true);

        try{
            // Load all influencers
            $influencers = Influencer::with(['posts'])->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get();
            $this->info("Influencers need update {$influencers->count()}");

            foreach($influencers as $influencer){
                // Update instagram media
                if($influencer->platform === 'instagram'){
                    $this->info("Update Instagram influencer @{$influencer->username}");
                    
                    foreach($influencer->posts as $post){
                        try{
                            // Get online media
                            $media = $this->instagram->getMedia($post->short_code);
                            $this->info("Post {$media['short_code']} successfully scraped!");

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
                            // Trace
                            Log::error($ex->getMessage());
                            $this->error($ex->getMessage());

                            // Break process if reach the Instagram limit
                            if($ex->getCode() === -2)
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
            Log::error($exception->getMessage(), ['context' => 'Influencers updater with code: ' . $exception->getCode()]);
            $this->error($exception->getMessage());

            return 0;
        }
    }
}
