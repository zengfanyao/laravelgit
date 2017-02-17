<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tools\Page;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->singleton('page',function(){
            return new Page;
        });
    }
}
