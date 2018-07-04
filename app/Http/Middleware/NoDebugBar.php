<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class NoDebugBar
 * @package App\Http\Middleware
 */
class NoDebugBar
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
        \Debugbar::disable();
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        \Debugbar::enable();
    }
}
