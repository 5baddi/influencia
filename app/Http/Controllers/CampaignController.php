<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Brand $brand)
    {
        return $brand->campaigns()
                    ->with('user', 'brand')
                    ->withCount('trackers')
                    // TODO: total estimated impressions
                    // TODO: total size of activated communities
                    ->get();
    }

    /**
     * Insert new campaign row
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validate request
        $request->validate([
            'name'      => 'required|string',
            'brand_id'  => 'required|integer|exists:brands,id'
        ]);

        // Insert new campaign row
        $campaign = Campaign::create([
            "name"      => $request->input("name"),
            "brand_id"  => $request->input("brand_id"),
            "user_id"   => Auth::id()
        ]);


        return Campaign::find($campaign->id)->with(['brand', 'user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
