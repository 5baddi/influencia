<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\DataTable\CampaignDTResource;
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
        // Check abilities
        abort_if(Gate::denies('list_campaign'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Load campaigns
        $campaigns = Campaign::with(['analytics'])
                        ->withCount('trackers')
                        ->where('brand_id', $brand->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->success(
            "Campaigns fetched successfully.", 
            CampaignDTResource::collection($campaigns)
        );
    }

    /**
     * Search for campaigns by active brand and search query
     *
     * @param \App\Brand $brand
     * @param string $query
     * @return \Illuminate\Http\Response
     */
    public function search(Brand $brand, string $query)
    {
        abort_if(Gate::denies('list_campaign'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Search by name
        $byName = Campaign::with('analytics')
                ->withCount('trackers')
                ->where('brand_id', $brand->id)
                ->whereRaw('LOWER(`name`) LIKE ?', ['%' . trim(strtolower($query)) . '%'])
                ->get();

        // By influencer name or username
        $byInfluencer = Campaign::with('aalytics')
                ->withCount('trackers')
                ->where('brand_id', $brand->id)
                ->get()
                ->filter(function($item) use($query){
                    $found = $item->influencers->filter(function($item) use($query){
                        return strpos(strtolower($item->name), strtolower($query)) !== false || strpos(strtolower($item->username), strtolower($query)) !== false;
                    });

                    if($found->count() !== 0)
                        return true;

                    return false;
                });

        $result = $byName->merge($byInfluencer);

        return response()->success(
            "Campaigns filtered successfully.", 
            CampaignDTResource::collection($result->unique()->sortByDesc('created_at'))
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
                ->orderBy('created_at', 'desc')
                ->get();

        $trackersCount = 0;
        $trackersList = collect();
        foreach($trackers as $item){
            $trackersCount += $item->trackers_count;

            if($trackersList->contains('id', $item->id))
                    continue;

                $trackersList->add($item);
        }

        $impressions = $this->campaignRepo->getEstimatedImpressions();
        $communities = $this->campaignRepo->getEstimatedCommunities();

        return response()->success("Campaigns fetched successfully.", 
            [
                'campaigns_count'       =>  $brand->campaigns->count(),
                'trackers_count'        =>  $trackersCount,
                'impressions'           =>  $impressions,
                'communities'           =>  $communities,
                // 'brands'                =>  Auth::user()->brands,
                // 'campaigns'             =>  Campaign::where('user_id', Auth::id())->get(),
                // 'trackers'              =>  Tracker::where('user_id', Auth::id())->get(),
                // 'influencers'           =>  Auth::user()->influencers,
                'latestCampaigns'       =>  $brand->campaigns()->take(5)->get(),
                'latestTrackers'        =>  $trackersList->take(5)->toArray()
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
        // Load analytics 
        $analytics = $campaign->load(['trackers', 'analytics']);

        return response()->success(
            "Campaign fetched successfully.",
            $analytics->toArray()
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
