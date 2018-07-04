<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;


/**
 * Class LogSuccessfulLogin
 * @package App\Listeners
 */
class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->is_online = true;
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }

}
