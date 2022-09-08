<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Tracker;
use App\Models\Campaign;
use App\Models\ShortLink;
use Carbon\Carbon;
use App\Models\Influencer;
use App\Models\BrandInfluencer;
use App\Jobs\ScrapPostJob;
use Illuminate\Support\Str;
use App\Jobs\ScrapInfluencerJob;
use App\Jobs\ScrapURLContentJob;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateTrackerRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateStoryTrackerRequest;
use App\Http\Resources\TrackerAnalyticsResource;
use App\Http\Resources\DataTable\TrackerDTResource;

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
        $trackers = Tracker::with(['campaign', 'analytics', 'influencers', 'shortlink'])
                        ->whereHas('campaign', function($camp) use($brand){
                            $camp->where('brand_id', $brand->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->success(
            "Trackers fetched successfully.",
            TrackerDTResource::collection($trackers)
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

        // Get trackers
        $trackers = Tracker::with(['campaign', 'analytics', 'influencers', 'shortlink'])
                        ->whereHas('campaign', function($camp) use($brand, $campaign){
                            $camp->where('brand_id', $brand->id)
                                ->where('id', $campaign->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->success(
            "Trackers fetched successfully.",
            TrackerDTResource::collection($trackers)
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

        // Search for trackers
        $trackers = Tracker::with(['user', 'campaign', 'shortlink', 'influencers'])
                            ->whereHas('campaign', function($camp) use($brand){
                                $camp->where('brand_id', $brand->id);
                            })
                            ->whereHas('influencers', function($inf) use($query){
                                $inf->whereRaw('LOWER(`name`) LIKE ?', ['%' . trim(strtolower($query)) . '%'])
                                    ->orWhereRaw('LOWER(`username`) LIKE ?', ['%' . trim(strtolower($query)) . '%']);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->success(
            "Trackers filtered successfully.",
            TrackerDTResource::collection($trackers)
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
        // Load tracker analytics
        $analytics = Tracker::with(['posts', 'campaign', 'shortlink', 'influencers'])->findOrFail($tracker->id);
        
        return response()->success(
            "Tracker fetched successfully.",
            new TrackerAnalyticsResource($analytics)
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
            return response()->success("Tracker {$tracker->name} status changed successfully.", Tracker::with(['user', 'campaign', 'shortlink', 'influencers'])->find($tracker->id));


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

        // Handle URL Tracker
        if($tracker->type === 'url'){
            $ShortLink = ShortLink::create([
                'tracker_id'    =>  $tracker->id,
                'link'          =>  $tracker->url,
                'code'          =>  Str::random(config('scraper.shortlink.length'))
            ]);
        
            // Dispatch scraping job
            ScrapURLContentJob::dispatch($ShortLink->load('tracker'))->onQueue('trackers');
        }

        // Dispatch scraping job
        if(in_array($tracker->platform, ['instagram', 'youtube']) && $tracker->type === 'post')
            ScrapPostJob::dispatch($tracker)->onQueue('trackers');

        return response()->success(
            "Tracker created successfully.",
            Tracker::with(['user', 'campaign', 'shortlink', 'influencers'])->find($tracker->id)
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

        // Validated data
        $data = $request->validated();

        // Story insights
        $story = [
            'reach'         =>  $data['reach'],
            'impressions'   =>  $data['impressions'],
            'interactions'  =>  $data['interactions'],
            'back'          =>  $data['back'],
            'forward'       =>  $data['forward'],
            'next_story'    =>  $data['next_story'],
            'exited'        =>  $data['exited'],
            'published_at'  =>  !is_null($data['published_at']) ? Carbon::parse($data['published_at'])->format("Y-m-d H:i:s") : null
        ];

        // Create new tracker
        $tracker = Tracker::create([
            'user_id'       =>  Auth::id(),
            'campaign_id'   =>  $data['campaign_id'],
            'name'          =>  $data['name'],
            'type'          =>  $data['type'],
            'platform'      =>  $data['platform'],
        ]);

        // Set story tracker
        $story['tracker_id'] = $tracker->id;

        // Upload story thumbnail
        if($request->hasFile('thumbnail')){
            $fileName = Str::slug($request->file('thumbnail')->getClientOriginalName()) . '_' . time() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnailPath = $request->file('thumbnail')->storeAs('influencers/instagram/temp/stories/thumbnails/', $fileName, 'local');
            
            if($thumbnailPath)
                $story['thumbnail'] = $thumbnailPath;
        }

        // Upload story video
        if($request->hasFile('story')){
            $fileName = Str::slug($request->file('story')->getClientOriginalName()) . '_' . time() . '.' . $request->file('story')->getClientOriginalExtension();
            $videoPath = $request->file('thumbnail')->storeAs('influencers/instagram/temp/stories/videos/', $fileName, 'local');
            
            if($videoPath)
                $story['story'] = $videoPath;
        }
        
        // Upload story proofs
        if($request->hasFile('proofs')){

        }

        // Verify if influencer already exists
        $exists = Influencer::where([
            'platform' => 'instagram',
            'username' => $data['username']
        ])->first();
        
        if(!is_null($exists)){
            // Set influencer to current selected brand
            BrandInfluencer::firstOrCreate([
                'brand_id'      =>  Auth::user()->selected_brand_id,
                'influencer_id' =>  $exists->id
            ]);
        }else{
            // Send create new influencer job
            ScrapInfluencerJob::dispatch(Auth::user(), $data['username'], $story)->onQueue('influencers');
        }

        return response()->success("Task executed in background, please wait...", [], 200);
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
            Tracker::with(['user', 'campaign', 'shortlink', 'infleuncers'])->find($tracker->id)
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
