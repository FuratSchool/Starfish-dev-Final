<?php

namespace App\Http\Middleware;

use App\Models\Access;
use Closure;
use Illuminate\Support\Facades\Route;

/**
 * Class CheckAccess
 * @package App\Http\Middleware
 */
class CheckAccess
{
    public function handle($request, Closure $next)
    {

        $route = $request->route()->getName();
        if (Access::where('route', '=', $route)->count() > 0) {
            if(auth()->user()->hasAccess($route)) {
                return $next($request);
            } else {
                \Session::flash('error', "Geen toegang tot pagina!");
                return redirect()->route('admin.admin');
            }
        }
        return $next($request);
    }
}
