<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class IsAdmin
 * @package App\Http\Middleware
 */
class IsAdmin
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
        session()->put('url.intended', url()->full());
        if(Auth::check() && Auth::user()->is_admin >= 1){
            session()->forget('url');
            return $next($request);
        }
        \Session::flash('error', "U moet ingelogd zijn om de door u opgevraagde pagina te bezoeken");
        return redirect(route('login'));

    }
}
