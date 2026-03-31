<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
 $schedule->call(function () {
        app(\App\Repositories\ReportRepo::class)->createReport([]);
    })->dailyAt('12:00');

    $schedule->call(function () {
            \Illuminate\Support\Facades\Cache::flush();
            \Illuminate\Support\Facades\Log::info("Sistem: Cache telah dibersihkan otomatis.");
        })->dailyAt('00:00');
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
