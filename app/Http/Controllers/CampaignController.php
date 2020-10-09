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
        return response()->success("Campaigns fetched successfully.", 
            $brand->campaigns()
                ->with('user', 'brand')
                ->withCount('trackers')
                // TODO: total estimated impressions
                // TODO: total size of activated communities
                ->get()
        );
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

        return response()->success(
            "Campaign created successfully.", 
            $campaign->load(['brand', 'user']),
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return response()->success(
            "Campaign fetched successfully.",
            $campaign->load('trackers')->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Campaign $campaign, Request $request)
    {
        // TODO: update campaign entity
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        // Delete campaign entity
        $campaign->delete();

        return response()->success("Campaign deleted successfully.", [], 204);
    }
}
