<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        Route::pattern('field', '\w+');
        Route::pattern('number', '[0-9A-Z]+');
        parent::boot();
    }

    public function map()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
