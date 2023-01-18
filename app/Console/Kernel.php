<?php

namespace App\Console;

use App\Console\Commands\Feed\ReadAndSyncPodcastFeeds;
use App\Console\Commands\OpenBooks\SyncOpenBooks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Nova\Trix\PruneStaleAttachments;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncOpenBooks::class,
        ReadAndSyncPodcastFeeds::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(new PruneStaleAttachments)
                 ->daily();
        $schedule->call(SyncOpenBooks::class)
                 ->dailyAt('23:00');
        $schedule->call(ReadAndSyncPodcastFeeds::class)
                 ->dailyAt('23:30');
    }

    /**
     * Register the commands for the application.
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
