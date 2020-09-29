<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Media;
use App\Tracker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTrackerRequest;
use App\Http\Requests\CreateStoryTrackerRequest;
use App\TrackerMedia;

class TrackerController extends Controller
{
    public function index()
    {
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
        // Create new tracker row
        $tracker = Tracker::create($request->all());

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
        // Create tracker
        $tracker = Tracker::create($request->all());

        // Upload story
        $storyFileName =  Str::slug($request->input('name') . '_') . time() . '.' . $request->file('story')->getClientOriginalExtension();
        $storyFilePath = $request->file('story')->storeAs('uploads', $storyFileName, 'public');
        $media = Media::create([
            'name'          =>  $storyFileName,
            'type'          =>  'media',
            'media_path'    =>  '/storage/' . $storyFilePath
        ]);
        TrackerMedia::create([
            'tracker_id'    =>  $tracker->id,
            'media_id'      =>  $media->id
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
        return response()->success(
            "Tracker fetched successfully.",
            $tracker->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracker $tracker)
    {
        // Delete tracker row
        $tracker->delete();

        return response()->success("Tracker deleted successfully.", [], 204);
    }
}
