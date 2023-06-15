<?php

namespace App\Console;

use App\Console\Commands\Database\CleanupLoginKeys;
use App\Console\Commands\Feed\ReadAndSyncPodcastFeeds;
use App\Console\Commands\MempoolSpace\CacheRecommendedFees;
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
        //$schedule->command(CacheRecommendedFees::class)->everyFourHours();
        $schedule->call(new PruneStaleAttachments)
                 ->daily();
        $schedule->command(SyncOpenBooks::class)
                 ->hourlyAt(15);
        $schedule->command(ReadAndSyncPodcastFeeds::class)
                 ->dailyAt('04:30');
        $schedule->command(CleanupLoginKeys::class)
                 ->everyFifteenMinutes();
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'BitcoinEvent',
        ])
                 ->dailyAt('08:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'CourseEvent',
        ])
                 ->dailyAt('09:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'MeetupEvent',
        ])
                 ->dailyAt('10:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'Meetup',
        ])
                 ->dailyAt('11:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'OrangePill',
        ])
                 ->dailyAt('12:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'LibraryItem',
        ])
                 ->dailyAt('13:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'BitcoinEvent',
        ])
                 ->dailyAt('14:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'CourseEvent',
        ])
                 ->dailyAt('15:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'MeetupEvent',
        ])
                 ->dailyAt('16:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'Meetup',
        ])
                 ->dailyAt('17:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'OrangePill',
        ])
                 ->dailyAt('18:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'LibraryItem',
        ])
                 ->dailyAt('19:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'BitcoinEvent',
        ])
                 ->dailyAt('20:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'LibraryItem',
        ])
                 ->dailyAt('21:00');
        $schedule->command(PublishUnpublishedItems::class, [
            '--model' => 'LibraryItem',
        ])
                 ->dailyAt('22:00');
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
