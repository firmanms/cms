<?php

namespace App\Providers;

use App\Services\ShowDinasIkm;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {  
            return new Client();  
        });  
  
        $this->app->singleton(ShowDinasIkm::class, function ($app) {  
            return new ShowDinasIkm($app->make(Client::class));  
        });  
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
