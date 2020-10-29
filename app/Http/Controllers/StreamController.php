<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Tracker;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    /**
     * Streamed the trackers data
     * 
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function trackers(Brand $brand)
    {
        // Init streamed response
        return response()->stream(function() use ($brand){
            while(true){
                if(connection_aborted())
                    break;

                // Load trackers data
                $trackers = Tracker::with(['user', 'campaign', 'medias', 'influencer'])
                ->whereHas('campaign', function($camp) use($brand){
                    $camp->where('brand_id', $brand->id);
                })
                ->get();

                // set data
                echo 'event:ping\n data: ' . json_encode($trackers) . '\n\n';
                ob_flush();
                flush();
                sleep(5); // 5s
            }
        }, 200, [
            'Content-Type'  =>  'text/event-stream',
            'Cach-Control'  =>  'no-cache'
        ]);
    }
}
