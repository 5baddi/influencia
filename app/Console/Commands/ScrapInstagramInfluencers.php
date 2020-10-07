<?php

namespace App\Console\Commands;

use App\Repositories\InfluencerPostRepository;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use App\Repositories\InfluencerRepository;
use Carbon\Carbon;

class ScrapInstagramInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram {--force=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap instagram influencers';

    /**
     * Instagram scraper
     * 
     * @var App\Services\InstagramScraper
     */
    private $instagramScraper;

    /**
     * Influencer account repository
     * 
     * @var App\Repositories\InfluencerRepository
     */
    private $repository;
    
    /**
     * Influencer post repository
     * 
     * @var App\Repositories\InfluencerPostRepository
     */
    private $postRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InstagramScraper $instagramScraper, InfluencerRepository $repository, InfluencerPostRepository $postRepository)
    {
        parent::__construct();

        // Init
        $this->instagramScraper = $instagramScraper;
        $this->repository = $repository;
        $this->postRepository = $postRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("=== Start scrap instagram influencers ===");
        $startTaskAt = microtime(true);

        // Get username's
        $influencers = $this->repository->all();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            // Scrap & update influencer details
            // TODO: add force option
            // if(!$this->argument('--force') && isset($influencer->updated_at) && $influencer->updated_at->diffInDays(Carbon::now()) === 0)
            // if(isset($influencer->updated_at) && $influencer->updated_at->diffInDays(Carbon::now()) === 0)
            //     continue;

            // Scrap account details
            $this->info("Start scraping account @" . $influencer->username);
            $accountDetails = $this->instagramScraper->byUsername($influencer->username);
            sleep(3);

            // Update influencer
            $this->repository->update($influencer, $accountDetails);
            $this->info("Successfully updated influencer ID: " . $influencer->id);
            $influencer->fresh();

            // Update influencer posts
            $this->info("Number of posts: " . $influencer->posts);
            $this->info("Start scraping medias ...");
            $instaMedias = $this->instagramScraper->getMedias($influencer);
            sleep(3);
            foreach($instaMedias as $media){
                $this->info("Start fetching media: " . $media['short_code']);
                // Update exists row
                $existsMedia = $this->postRepository->exists($influencer, $media['post_id']);
                if(!is_null($existsMedia)){
                    $this->info("Update post: " . $existsMedia->short_code);
                    $this->postRepository->update($existsMedia, $media);
                    continue;
                }

                $this->info("Create post: " . $media['short_code']);
                $this->postRepository->create($media);

                sleep(3);
            }
        }

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }
}
