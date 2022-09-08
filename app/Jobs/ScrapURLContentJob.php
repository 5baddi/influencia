<?php

namespace App\Jobs;

use Goose\Client;
use App\Models\ShortLink;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScrapURLContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

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
        $this->goose = new Client([
            'verify'            =>  !config('app.debug'),
            'http_errors'       =>  false
        ]);
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

    /**
     * On job failed
     *
     * @param \Exception|null $exception
     * @return void
     */
    public function fail($exception = null)
    {
        // Set tracker on failed status
        $this->shortLink->tracker->update(['queued' => 'failed']);
        Log::error("Failed to extract URL info | " . $exception->getMessage());
    }
}
