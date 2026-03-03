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
        $this->app->bind(\App\Repositories\Interfaces\CrudCatInterface::class,
         \App\Repositories\CrudCatRepo::class);
        $this->app->bind(\App\Repositories\Interfaces\CrudMenusInterface::class,
         \App\Repositories\MenuRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
