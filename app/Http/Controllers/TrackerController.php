<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Tracker;
use App\Campaign;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTrackerRequest;
use App\Http\Requests\CreateStoryTrackerRequest;

class TrackerController extends Controller
{
    /**
     * Fetch trackers by brand.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchByBrand(Brand $brand)
    {
        return Tracker::with(['user', 'campaign', 'medias'])
                        ->whereHas('campaign', function($camp) use($brand){
                            $camp->where('brand_id', $brand->id);
                        })
                        ->get();
    }

    /**
     * Create campaign tracker
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateTrackerRequest $request)
    {
        return Tracker::create($request->all());
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStory(CreateStoryTrackerRequest $request)
    {
        die($request->file('story'));
        // Create tracker
        $tracker = Tracker::create($request->all());

        return $tracker;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
