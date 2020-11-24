<?php

namespace App\Http\Controllers;

use App\Influencer;
use App\InfluencerPost;
use Illuminate\Http\Request;

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
            Influencer::all()
        );
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
