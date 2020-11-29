<?php

namespace App\Http\Controllers;

use App\Influencer;
use App\InfluencerPost;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateInfluencerRequest;
use Symfony\Component\HttpFoundation\Response;

class InfluencerController extends Controller
{
    /**
     * Fetch all influencers
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success("Influencers fetched successfully.", 
            Influencer::withCount('posts')->get()
        );
    }

    public function create(CreateInfluencerRequest $request, InstagramScraper $instagram)
    {
        // Check ability
        abort_if(Gate::denies('create_influencer') && !Auth()->user()->is_superadmin, Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Get validated data
        $data = $request->validated();
        
        try{
            // Add instagram influencer
            if($data['platform'] === 'instagram'){
                if(filter_var($data['username'],FILTER_VALIDATE_INT) !== false)
                    $account = $instagram->byId((int)$data['username']);
                else
                    $account = $instagram->byUsername((int)$data['username']);

                // Store account
                $influencer = Influencer::create($account);
                
                return response()->success("Influencer @{$influencer->username} created successfully.", $influencer, 201);
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
}
