<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;  
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set the default string length to 191
        Schema::defaultStringLength(191);
    }
}
