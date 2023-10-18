<?php

namespace App\Providers;

use App\Services\ResponseService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind('ApiResponse', function () {
            return new ResponseService;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
