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
        $this->app->bind(\App\Interfaces\CatInterface::class,
            \App\Repositories\CatRepo::class);
        $this->app->bind(\App\Interfaces\MenusInterface::class,
            \App\Repositories\MenuRepo::class);
        $this->app->bind(\App\Interfaces\AuthInterface::class,
            \App\Repositories\AuthRepo::class);
        $this->app->bind(\App\Interfaces\OrderInterface::class,
            \App\Repositories\OrderRepo::class);
        $this->app->bind(\App\Interfaces\ReportInterface::class,
            \App\Repositories\ReportRepo::class);
        $this->app->bind(\App\Interfaces\PaymentInterface::class,
            \App\Repositories\PaymentRepo::class);
        $this->app->bind(\App\Interfaces\OrderItemInterface::class,
            \App\Repositories\OrderItemRepo::class);
            $this->app->bind(\App\Interfaces\CartInterface::class,
            \App\Repositories\CartRepo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
