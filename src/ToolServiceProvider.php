<?php

namespace Zareismail\MetaData;
 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    } 

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
