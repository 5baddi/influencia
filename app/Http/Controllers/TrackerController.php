<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Tracker;
use App\Campaign;
use App\ShortLink;
use Carbon\Carbon;
use App\Influencer;
use App\TrackerMedia;
use App\Jobs\ScrapPostJob;
use Illuminate\Support\Str;
use App\Jobs\ScrapURLContentJob;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateTrackerRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateStoryTrackerRequest;

class TrackerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('list_tracker') && Gate::denies('viewAny', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success(
            "Trackers fetched successfully.",
            Tracker::all()
        );
    }
    
    /**
     * Fetch trackers by brand.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchByBrand(Brand $brand)
    {
        abort_if(Gate::denies('list_tracker') && Gate::denies('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Load trackers
        $trackers = Tracker::with(['campaign', 'analytics', 'influencers'])
                        ->whereHas('campaign', function($camp) use($brand){
                            $camp->where('brand_id', $brand->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->success(
            "Trackers fetched successfully.",
            $trackers->toArray()
        );
    }
    
    /**
     * Fetch trackers by campaign.
     *
     * @return \Illuminate\Http\Response
     */
    public function byCampaign(Brand $brand, Campaign $campaign)
    {
        abort_if(Gate::denies('list_tracker') && Gate::denies('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success(
            "Trackers fetched successfully.",
            Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'influencers'])
                    ->whereHas('campaign', function($camp) use($brand, $campaign){
                        $camp->where('brand_id', $brand->id)
                            ->where('id', $campaign->id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    // ->paginate(Application::DEFAULT_PAGINATION)
        );
    }

    /**
     * Search for trackers by active brand and search query
     *
     * @param \App\Brand $brand
     * @param string $query
     * @return \Illuminate\Http\Response
     */
    public function search(Brand $brand, string $query)
    {
        abort_if(Gate::denies('list_tracker') && Gate::denies('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success(
            "Trackers filtered successfully.",
            Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'influencers'])
                    ->whereHas('campaign', function($camp) use($brand){
                        $camp->where('brand_id', $brand->id);
                    })
                    ->whereHas('influencers', function($inf) use($query){
                        $inf->whereRaw('LOWER(`name`) LIKE ?', ['%' . trim(strtolower($query)) . '%'])
                            ->orWhereRaw('LOWER(`username`) LIKE ?', ['%' . trim(strtolower($query)) . '%']);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    // ->paginate(Application::DEFAULT_PAGINATION)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function analytics(Tracker $tracker)
    {
        return response()->success(
            "Tracker fetched successfully.",
            Tracker::with(['posts', 'user', 'medias', 'campaign', 'shortlink', 'influencers'])->find($tracker->id)
        );
    }

    /**
     * Enable/Disable tracker
     *
     * @param \App\Tracker $tracker
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Tracker $tracker)
    {
        // Check ability
        abort_if(Gate::denies('changeStatus', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

        $updated = $tracker->update([
            'status'    =>  !$tracker->status
        ]);

        if($updated)
            return response()->success("Tracker {$tracker->name} status changed successfully.", Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'influencers'])->find($tracker->id));


        return response()->error("Something going wrong! Please try again or contact the support..");
    }

    /**
     * Create campaign tracker
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateTrackerRequest $request)
    {
        abort_if(Gate::denies('create_tracker') && Gate::denies('create', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Create new tracker row
        $tracker = Tracker::create($request->validated());
        $tracker = $tracker->refresh();

        // Handle URL Tracker
        if($tracker->type === 'url'){
            $ShortLink = ShortLink::create([
                'tracker_id'    =>  $tracker->id,
                'link'          =>  $tracker->url,
                'code'          =>  Str::random(config('scraper.shortlink.length'))
            ]);

            // Dispatch scraping job
            ScrapURLContentJob::dispatch($ShortLink->load('tracker'))->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));
        }

        // Dispatch scraping job
        if(in_array($tracker->platform, ['instagram', 'youtube']) && $tracker->type === 'post')
            ScrapPostJob::dispatch($tracker)->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));

        return response()->success(
            "Tracker created successfully.",
            Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'influencers'])->find($tracker->id)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStory(CreateStoryTrackerRequest $request, InstagramScraper $scraper)
    {
        abort_if(Gate::denies('create_tracker') && Gate::denies('create', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Create tracker
        $tracker = Tracker::create($request->validated());
        $tracker = $tracker->refresh();

        // Upload story sequences
        $medias = [];
        if($request->hasFile('story')){
            foreach($request->file('story') as $file){
                $storyFileName =  Str::slug($request->input('name') . '_') . time() . '.' . $file->getClientOriginalExtension();
                $storyFilePath = $file->storeAs('uploads', $storyFileName, 'public');
                $medias[] = TrackerMedia::create([
                    'tracker_id'    =>  $tracker->id,
                    'name'          =>  $storyFileName,
                    'type'          =>  'media',
                    'media_path'    =>  '/storage/' . $storyFilePath
                ]);
            }
        }

        // Srap Influencer
        $scraper = $scraper->authenticate();
        $instagramUser = $scraper->byUsername($request->input('username'));
        $influencer = Influencer::create($instagramUser);

        return response()->success(
            "Story tracker created successfully.",
            Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'infleuncers'])->find($tracker->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tracker $tracker)
    {
        abort_if(Gate::denies('show_tracker') && Gate::denies('view', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success(
            "Tracker fetched successfully.",
            Tracker::with(['user', 'campaign', 'medias', 'shortlink', 'infleuncers'])->find($tracker->id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function update(Tracker $tracker)
    {
        abort_if(Gate::denies('edit_tracker') && Gate::denies('update', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tracker $tracker
     * @return \Illuminate\Http\Response
     */
    public function delete(Tracker $tracker)
    {
        abort_if(Gate::denies('delete', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete tracker row
        $tracker->delete();

        return response()->success("Tracker deleted successfully.", [], 204);
    }
}
