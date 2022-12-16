<?php

namespace App\Providers;

use Inertia\ResponseFactory;
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
        ResponseFactory::macro('dialog', function ($modal) {
            inertia()->share(['dialog' => $modal]);
        });
    }
}
