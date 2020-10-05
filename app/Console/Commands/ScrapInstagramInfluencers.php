<?php

namespace App\Console\Commands;

use App\Repositories\InfluencerPostRepository;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use App\Repositories\InfluencerRepository;

class ScrapInstagramInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram';

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

        // Get username's
        $usernames = $this->repository->getUsernames();
        $this->info("Number of account to sync: " . count($usernames));

        // Scrap each influencer details
        foreach($usernames as $id => $username){
            // Scrap account details
            $accountDetails = $this->instagramScraper->byUsername($username);
            sleep(3);

            // Get influencer entity
            $influencer = $this->repository->find($id);
            if(is_null($influencer))
                continue;

            // Update influencer
            $this->repository->update($influencer, $accountDetails);
            $this->info("Successfully updated influencer ID: " . $influencer->id);

            // Update influencer posts
            $this->info("Number of posts: " . $influencer->posts);
            $instaMedias = $this->instagramScraper->getMedias($influencer);
            sleep(3);
            foreach($instaMedias as $media){
                // Update exists row
                $existsMedia = $this->postRepository->exists($influencer, $media['post_id']);
                if(!is_null($existsMedia)){
                    $this->info("Update post: " . $existsMedia->short_code);
                    $this->postRepository->update($existsMedia, $media);
                    continue;
                }

                $this->info("Create post: " . $existsMedia->short_code);
                $this->postRepository->create($media);

                sleep(3);
            }
        }

        $this->info("=== Done ===");
    }
}
