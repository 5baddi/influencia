<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware;

class BlockRobotsMiddleware extends RobotsMiddleware
{   
     /**
     * @return string|bool
     */
    protected function shouldIndex(Request $request)
    {
        return 'none';
    }
}
