<?php

namespace App\Observers;

use App\Models\CourseEvent;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(CourseEvent $event): void
    {
        //
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(CourseEvent $event): void
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(CourseEvent $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(CourseEvent $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(CourseEvent $event): void
    {
        //
    }
}
