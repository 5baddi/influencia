<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Influencer;
use App\Models\InfluencerPost;
use App\Models\BrandInfluencer;
use App\Models\InfluencerStory;
use App\Jobs\ScrapInfluencerJob;
use App\Services\YoutubeScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\StoriesCollection;
use App\Http\Requests\CreateInfluencerRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\DataTable\InfluencerDTResource;

class InfluencerController extends Controller
{
    /**
     * Fetch all influencers
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function byBrand(Brand $brand)
    {
        // Load brand influencers
        $brand = Brand::with(['influencers'])
                            ->where('id', $brand->id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        return response()->success(
            "Influencers fetched successfully.", 
            InfluencerDTResource::collection($brand->influencers)
        );
    }

     /**
     * Fetch stories by brand
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function storiesByBrand(Brand $brand)
    {
        // Load brand influencers
        $ids = BrandInfluencer::where('brand_id', $brand->id)->pluck('influencer_id')->toArray();
        
        // Load stories
        $stories = InfluencerStory::with(['influencer'])
                        ->whereIn('influencer_id', $ids)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return response()->success(
            "Stories fetched successfully.", 
            [
                'items'         =>  StoriesCollection::collection($stories->getCollection()),
                'pagination'    =>  [
                    'total'     =>  $stories->total(),
                    'count'     =>  $stories->count(),
                    'perPage'   =>  $stories->perPage(),
                    'currentPage'   =>  $stories->currentPage(),
                    'lastPage'      =>  $stories->lastPage(),
                ]
            ],
        );
    }

    public function create(CreateInfluencerRequest $request, YoutubeScraper $youtube)
    {
        // Check ability
        abort_if(Gate::denies('create_influencer') && !Auth()->user()->is_superadmin, Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Get validated data
        $data = $request->validated();
        
        try{   
            // Add instagram influencer
            if($data['platform'] === 'instagram'){
                // Verify if influencer already exists
                $exists = Influencer::where([
                    'platform' => 'instagram',
                    (filter_var($data['username'], FILTER_VALIDATE_INT) !== false && preg_match('/^[0-9]*$/', $data['username']) ? 'account_id' : 'username') => $data['username']
                ])->first();
                
                if(!is_null($exists)){
                    // Set influencer to current selected brand
                    BrandInfluencer::firstOrCreate([
                        'brand_id'      =>  Auth::user()->selected_brand_id,
                        'influencer_id' =>  $exists->id
                    ]);

                    return response()->success(
                        "Influencer added successfully.",
                        $exists->loadCount(['posts', 'trackers']), 
                        201
                    ); 
                }

                // Send create new influencer job
                ScrapInfluencerJob::dispatch(Auth::user(), $data['username'])->onQueue('influencers');
                
                return response()->success("Task executed in background, please wait...", [], 200);
            }elseif($data['platform'] === 'youtube'){
                // Extract account ID
                if(filter_var($data['username'], FILTER_VALIDATE_URL))
                    $data['username'] = $youtube->extractChannelID($data['username']);

                // Verify channel ID
                if(is_null($data['username']))
                    return response()->error("Influencer with given identify does not exists!", [], 404);

                // Verify if influencer already exists
                $exists = Influencer::where([
                    'platform'  => 'youtube',
                    'account_id' => $data['username']
                ])->first();
                
                if(!is_null($exists)){
                    // Set influencer to current selected brand
                    BrandInfluencer::firstOrCreate([
                        'brand_id'      =>  Auth::user()->selected_brand_id,
                        'influencer_id' =>  $exists->id
                    ]);

                    return response()->success(
                        "Influencer added successfully.",
                        $exists->loadCount(['posts', 'trackers']), 
                        201
                    ); 
                }

                // Get channel details
                $details = $youtube->getChannelByID($data['username']);
                // Store account
                $influencer = Influencer::create($details);
                
                return response()->success("Influencer @{$influencer->name} created successfully.", $influencer, 201);
            }
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
            
            // Influencer does not exists
            if($ex->getCode() === 404)
                return response()->error("Influencer with given identify does not exists!", [], 404);

            return response()->error("Something going wrong! Please try again...", [], 500);
        }

        return response()->error("Platform not supported! please contact the support...", [], 400);
    }

    /**
     * Fetch influencer entity
     *
     * @param  \App\Influencer  $influencer
     * @return \Illuminate\Http\Response
     */
    public function show(Influencer $influencer)
    {
        return response()->success("Influencer fetched successfully.", 
            $influencer->toArray()
        );
    }

    /**
     * Fetch influencer posts
     *
     * @param  \App\Influencer  $influencer
     * @return \Illuminate\Http\Response
     */
    public function content(Influencer $influencer)
    {
        return response()->success("Posts of Influencer ID:{$influencer->id} fetched successfully.", 
            InfluencerPost::where('influencer_id', $influencer->id)->paginate(25)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Influencer  $influencer
     * @return \Illuminate\Http\Response
     */
    public function delete(Influencer $influencer)
    {
        abort_if(Gate::denies('delete', $influencer), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Check is not linked to any tracker
        $influencer = Influencer::withCount('trackers')->find($influencer->id);
        if($influencer->trackers_count > 0)
            return response()->error("You can't remove this influencer because is linked to {$influencer->trackers_count} trackers!", [], 400);

        // Delete influencer
        $influencer->delete();

        return response()->success("Influencer deleted successfully.", [], 204);
    }
}
