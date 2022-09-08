<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Tracker;
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
                ->get()->toArray();

                // set data
                echo 'id:' . uniqid() . PHP_EOL . 'data: ' . json_encode($trackers) . PHP_EOL;
                ob_flush();
                flush();
                usleep(200000); // 0.2s
            }
        }, 200, [
            'Content-Type'  =>  'text/event-stream',
            'Cach-Control'  =>  'no-cache'
        ]);
    }
}
