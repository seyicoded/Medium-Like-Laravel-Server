<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class eAPICALLERServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::bind('test',function() {
            return new \App\Providers\eAPICALLERServiceProvider();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
