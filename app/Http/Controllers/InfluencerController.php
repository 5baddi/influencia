<?php

namespace App\Http\Controllers;

use App\Influencer;
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
            $influencer
                ->load('posts')
                ->toArray()
        );
    }
}
