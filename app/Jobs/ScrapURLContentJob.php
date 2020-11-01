<?php

namespace App\Jobs;

use App\ShortLink;
use Goose\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScrapURLContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Short Link entity
     *
     * @var \App\ShortLink
     */
    private $shortLink;

    /**
     * Goose client
     *
     * @var \Goose\Client
     */
    private $goose;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ShortLink $shortLink)
    {
        // Init
        $this->shortLink = $shortLink;
        $this->goose = new Client();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get tracker and update status to progress
        $this->shortLink->tracker->update(['queued' => 'progress']);

        try{
            // Extract content
            $content = $this->goose->extractContent($this->shortLink->link);
            $this->shortLink->update([
                'title'                 =>  $content->getTitle(),
                'meta_description'      =>  $content->getMetaDescription(),
                'meta_keywords'         =>  $content->getMetaKeywords(),
                'tags'                  =>  $content->getTags(),
                'top_image_url'         =>  !is_null($content->getTopImage()) ? $content->getTopImage()->getImageSrc() : null,
            ]);
            $this->shortLink->tracker->update(['queued' => 'finished']);
        }catch(\Exception $ex){
            $this->fail($ex);
        }
    }

    public function fail($exception = null)
    {
        // Set tracker on failed status
        $this->shortLink->tracker->update(['queued' => 'failed']);

        Log::error("Failed to extract URL info | " . $exception->getMessage());
    }
}
