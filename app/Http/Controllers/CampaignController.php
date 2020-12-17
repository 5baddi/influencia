<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CampaignRepository;
use App\Http\Requests\UpdateCampaignRequest;
use Symfony\Component\HttpFoundation\Response;

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
        abort_if(Gate::denies('list_campaign'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success("Campaigns fetched successfully.", 
            $brand->campaigns()
                ->with(['user', 'brand'])
                ->withCount('trackers')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * Get campaigns statistics by active brand
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics(Brand $brand)
    {
        abort_if(Gate::denies('list_campaign'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Load campaigns
        $trackers = $brand->campaigns()
                ->withCount(['trackers'])
                ->get();

        $trackersCount = 0;
        foreach($trackers as $item)
            $trackersCount += $item->trackers_count;

        $impressions = $this->campaignRepo->getEstimatedImpressions();
        $communities = $this->campaignRepo->getEstimatedCommunities();

        return response()->success("Campaigns fetched successfully.", 
            [
                'campaigns_count'       =>  $brand->campaigns->count(),
                'trackers_count'        =>  $trackersCount,
                'impressions'           =>  $impressions,
                'communities'           =>  $communities,
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
        return response()->success(
            "Campaign fetched successfully.",
            $campaign->load('trackers')
        );
    }

    /**
     * Enable/Disable campaign
     * 
     * @param \App\Campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Campaign $campaign)
    {
        // Check ability
        abort_if(Gate::denies('changeStatus', $campaign), Response::HTTP_FORBIDDEN, "403 Forbidden");

        $updated = $campaign->update([
            'status'    =>  !$campaign->status
        ]);

        if($updated)
            return response()->success("Campaign {$campaign->name} status changed successfully.", $campaign->refresh());

            
        return response()->error("Something going wrong! Please try again or contact the support..");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Campaign $campaign, UpdateCampaignRequest $request)
    {
        abort_if(Gate::denies('edit_campaign') && Gate::denies('update', $campaign), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Set data
        $data = $request->validated();

        // Update the brand
        $campaign->update($data);

        return response()->success("Campaign updated successfully.", Campaign::with(['user', 'brand'])->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function delete(Campaign $campaign)
    {
        abort_if(Gate::denies('delete_campaign'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete campaign entity
        $campaign->delete();

        return response()->success("Campaign deleted successfully.", [], 204);
    }
}
