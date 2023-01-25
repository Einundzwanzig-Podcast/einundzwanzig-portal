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
        $schedule->command(SyncOpenBooks::class)
                 ->dailyAt('04:00');
        $schedule->command(ReadAndSyncPodcastFeeds::class)
                 ->dailyAt('04:30');
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
