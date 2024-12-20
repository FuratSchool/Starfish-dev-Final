<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RedirectIfFilterTypeNull
 * @package App\Http\Middleware
 */
class RedirectIfFilterTypeNull
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
            if ($request->has("filter_type")) {
                if ($request->filter_type == 'init') {
                    return redirect()->to(url()->current() . '?' . http_build_query($request->except("filter_type")));
                }
            }
        return $next($request);
    }
}
