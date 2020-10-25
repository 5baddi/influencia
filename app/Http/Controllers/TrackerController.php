<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Tracker;
use Carbon\Carbon;
use App\TrackerMedia;
use Illuminate\Support\Str;
use App\Jobs\ScrapInstagramPostJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateTrackerRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateStoryTrackerRequest;
use App\Jobs\ScrapURLContentJob;
use App\ShortLink;

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

        return response()->success(
            "Trackers fetched successfully.",
            Tracker::with(['user', 'campaign', 'medias'])
                    ->whereHas('campaign', function($camp) use($brand){
                        $camp->where('brand_id', $brand->id);
                    })
                    ->get()
                    // ->paginate(Application::DEFAULT_PAGINATION)
        );
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
                'code'          =>  Str::random(env('SHORTLINK_LENGTH'))
            ]);
            
            // Dispatch scraping job
            ScrapURLContentJob::dispatch($ShortLink->load('tracker'))->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));
        }

        // Dispatch scraping job
        if($tracker->platform === 'instagram' && $tracker->type === 'post')
            ScrapInstagramPostJob::dispatch($tracker)->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));

        return response()->success(
            "Tracker created successfully.",
            $tracker
        );
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStory(CreateStoryTrackerRequest $request)
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
        

        return response()->success(
            "Story tracker created successfully.",
            $tracker->load('medias')
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
            $tracker->toArray()
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
    public function destroy(Tracker $tracker)
    {
        abort_if(Gate::denies('delete_tracker') && Gate::denies('delete', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete tracker row
        $tracker->delete();

        return response()->success("Tracker deleted successfully.", [], 204);
    }
}
