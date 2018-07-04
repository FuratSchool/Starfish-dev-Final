<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

/**
 * Class inGroup
 * @package App\Http\Middleware
 */
class inGroup
{

    /**
     * Handle an incoming request
     *
     * @param $request
     * @param Closure $next
     * @param Group $group
     * @return $this|mixed
     */
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->groups()->get() as $item) {
            if ($request->group->name == $item->id or auth()->user()->is_admin >= 3) {
                return $next($request);
            }
        }
        $errors = new MessageBag();
        $errors->add('error', 'U heeft geen toegang tot de gevraagde pagina <br> Foutmelding: Geen lid van groep');
        return redirect()->back()->withErrors($errors);
    }
}
