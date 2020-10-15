<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CampaignRepository;

class CampaignController extends Controller
{
    /**
     * 
     * @var \App\Repositories\CampaignRepository
     */
    private $campaignRepo;

    public function __construct(CampaignRepository $campaignRepo)
    {
        $this->campaignRepo = $campaignRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byBrand(Brand $brand)
    {
        // Load data
        $campaigns = $brand->campaigns()
                ->with('user', 'brand')
                ->withCount('trackers')
                ->get();

        $impressions = $this->campaignRepo->getEstimatedImpressions();
        $communities = $this->campaignRepo->getEstimatedCommunities();

        return response()->success("Campaigns fetched successfully.", 
            [
                'all'           =>  $campaigns,
                'impressions'   =>  $impressions,
                'communities'   =>  $communities,
            ]
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
    public function analytics(Campaign $campaign)
    {
        // Load data
        $campaign = $campaign->load('trackers');
        $impressions = $this->campaignRepo->getEstimatedImpressions();
        $organicImpressions = $this->campaignRepo->getEstimatedOrganicImpressions();
        $communities = $this->campaignRepo->getEstimatedCommunities();
        $organicCommunities = $this->campaignRepo->getEstimatedOrganicCommunities();
        $views = $this->campaignRepo->getViews();
        $organicViews = $this->campaignRepo->getOrganicViews();
        $engagements = $this->campaignRepo->getEngagements();
        $organicEngagements = $this->campaignRepo->getOrganicEngagements();

        return response()->success(
            "Campaign fetched successfully.",
            [
                'data'          =>  $campaign,
                'impressions'   =>  $impressions,
                'communities'   =>  $communities,
                'views'         =>  $views,
                'engagements'   =>  $engagements,
                'organicImpressions'    =>  $organicImpressions,
                'organicCommunities'    =>  $organicCommunities,
                'organicViews'          =>  $organicViews,
                'organicEngagements'    =>  $organicEngagements
            ]
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
