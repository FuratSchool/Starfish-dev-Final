<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;


/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        setlocale(LC_TIME, 'nl');

        Carbon::setLocale(config('nl'));

        Relation::morphMap([
            'users' => 'App\Models\User',
            'specialists' => 'App\Models\Specialist',
            'specialisms' => 'App\Models\Specialism',
            'complaints' => 'App\Models\Complaint',
            'therapies' => 'App\Models\Therapy',
            'diverses' => 'App\Models\Diverse',
            'groups' => 'App\Models\Group',
            'tasks' => 'App\Models\Task',
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
