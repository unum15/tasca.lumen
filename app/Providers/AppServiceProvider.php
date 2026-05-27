<?php

namespace App\Providers;

use Carbon\Carbon;
use DB;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Unum\Maker\MakerServiceProvider::class);
        }
    }
    
    public function boot()
    {
        if (env('DB_LOGGING', false) === true) {
            DB::listen(function($query) {
                Log::info($query->sql, $query->bindings, $query->time);
            });
        }
    }
}
