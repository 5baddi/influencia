<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Return unauthenticated if credentials wrong
        if(!$this->isAuthenticated($request->header('PHP_AUTH_USER'), $request->header('PHP_AUTH_PW')))
            return abort(401);

        return $next($request);
    }

    /**
     * Validate inserted basic auth credentials
     *
     * @param string $user
     * @param string $password
     * @return boolean
     */
    private function isAuthenticated(string $user, string $password) : bool
    {
        return ($user === 'project@baddi.info' && $password === 'web2020');
    }
}
