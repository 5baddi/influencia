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

class TrackerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('list_tracker'), Response::HTTP_FORBIDDEN, "403 Forbidden");

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
        abort_if(Gate::denies('list_tracker') || Auth::user()->cannot('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

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
        abort_if(Gate::denies('create_tracker'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Create new tracker row
        $tracker = Tracker::create($request->all());
        $tracker = $tracker->refresh();

        // Dispatch scraping job
        if($tracker->platform === 'instagram')
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
        abort_if(Gate::denies('create_tracker'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Create tracker
        $tracker = Tracker::create($request->all());
        $tracker = $tracker->refresh();

        // Upload story
        $storyFileName =  Str::slug($request->input('name') . '_') . time() . '.' . $request->file('story')->getClientOriginalExtension();
        $storyFilePath = $request->file('story')->storeAs('uploads', $storyFileName, 'public');
        $media = TrackerMedia::create([
            'tracker_id'    =>  $tracker->id,
            'name'          =>  $storyFileName,
            'type'          =>  'media',
            'media_path'    =>  '/storage/' . $storyFilePath
        ]);

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
        abort_if(Gate::denies('show_tracker') || Auth::user()->cannot('view', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

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
        abort_if(Gate::denies('edit_tracker') || Auth::user()->cannot('update', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tracker $tracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracker $tracker)
    {
        abort_if(Gate::denies('delete_tracker') || Auth::user()->cannot('delete', $tracker), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete tracker row
        $tracker->delete();

        return response()->success("Tracker deleted successfully.", [], 204);
    }
}
