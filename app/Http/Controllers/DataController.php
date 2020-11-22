<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    /**
     * Get dashboard statistics
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardStatistics()
    {
        return response()->success("Successfully loaded the statistics", [
            'brands'    =>  Auth::user()->brands,
            'campaigns' =>  Campaign::where('user_id', Auth::id())->get(),
            'trackers'  =>  Tracker::where('user_id', Auth::id())->get(),
            'influencers'   =>  Auth::user()->influencers
        ]);
    }
}
