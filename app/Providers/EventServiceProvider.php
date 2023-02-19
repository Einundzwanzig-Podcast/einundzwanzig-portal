<?php

namespace App\Providers;

use App\Listeners\AddLoginReputation;
use App\Models\BitcoinEvent;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\LibraryItem;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use App\Models\OrangePill;
use App\Observers\BitcoinEventObserver;
use App\Observers\CourseEventObserver;
use App\Observers\CourseObserver;
use App\Observers\LibraryItemObserver;
use App\Observers\MeetupEventObserver;
use App\Observers\MeetupObserver;
use App\Observers\OrangePillObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [
            AddLoginReputation::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Meetup::observe(MeetupObserver::class);
        MeetupEvent::observe(MeetupEventObserver::class);
        OrangePill::observe(OrangePillObserver::class);
        CourseEvent::observe(CourseEventObserver::class);
        Course::observe(CourseObserver::class);
        BitcoinEvent::observe(BitcoinEventObserver::class);
        LibraryItem::observe(LibraryItemObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
