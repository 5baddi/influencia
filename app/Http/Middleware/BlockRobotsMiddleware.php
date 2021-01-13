<?php

namespace App\Http\Middleware;

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
