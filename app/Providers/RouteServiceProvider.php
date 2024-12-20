<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Route::bind('specialist', function ($id) {
            return \App\Models\Specialist::withTrashed()->where('id', $id)->first();
        });
        Route::bind('specialism', function ($id) {
            return \App\Models\Specialism::withTrashed()->where('id', $id)->first();
        });
        Route::bind('therapy', function ($id) {
            return \App\Models\Therapy::withTrashed()->where('id', $id)->first();
        });
        Route::bind('complaint', function ($id) {
            return \App\Models\Complaint::withTrashed()->where('id', $id)->first();
        });
        Route::bind('message', function ($id) {
            return \App\Models\Message::withTrashed()->where('id', $id)->first();
        });
        Route::bind('task', function ($id) {
        return \App\Models\Task::withTrashed()->where('id', $id)->first();
      });

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
