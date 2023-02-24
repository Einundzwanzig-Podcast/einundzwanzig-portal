<?php

namespace App\Console;

use App\Console\Commands\Database\CleanupLoginKeys;
use App\Console\Commands\Feed\ReadAndSyncPodcastFeeds;
use App\Console\Commands\Nostr\PublishUnpublishedItems;
use App\Console\Commands\OpenBooks\SyncOpenBooks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Nova\Trix\PruneStaleAttachments;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncOpenBooks::class,
        ReadAndSyncPodcastFeeds::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(new PruneStaleAttachments)
                 ->daily();
        $schedule->command(SyncOpenBooks::class)
                 ->dailyAt('04:00');
        $schedule->command(ReadAndSyncPodcastFeeds::class)
                 ->dailyAt('04:30');
        $schedule->command(CleanupLoginKeys::class)
                 ->everyFifteenMinutes();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'LibraryItem',
        ])
                 ->everySixHours();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'BitcoinEvent',
        ])
                 ->hourly();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'CourseEvent',
        ])
                 ->everyTwoHours();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'MeetupEvent',
        ])
                 ->everyThreeHours();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'Meetup',
        ])
                 ->everyFourHours();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'Course',
        ])
                 ->everySixHours();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'OrangePill',
        ])
                 ->everyFourHours();
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
