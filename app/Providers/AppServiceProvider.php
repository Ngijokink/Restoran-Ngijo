<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\CrudCatInterface::class,
         \App\Repositories\CrudCatRepo::class);
        $this->app->bind(\App\Interfaces\CrudMenusInterface::class,
         \App\Repositories\CrudMenuRepo::class);
        $this->app->bind(\App\Interfaces\AuthInterface::class,
         \App\Repositories\AuthRepo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
