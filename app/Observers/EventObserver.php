<?php

namespace App\Observers;

use App\Models\CourseEvent;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\CourseEvent  $event
     * @return void
     */
    public function created(CourseEvent $event)
    {
        //
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param  \App\Models\CourseEvent  $event
     * @return void
     */
    public function updated(CourseEvent $event)
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     *
     * @param  \App\Models\CourseEvent  $event
     * @return void
     */
    public function deleted(CourseEvent $event)
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     *
     * @param  \App\Models\CourseEvent  $event
     * @return void
     */
    public function restored(CourseEvent $event)
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     *
     * @param  \App\Models\CourseEvent  $event
     * @return void
     */
    public function forceDeleted(CourseEvent $event)
    {
        //
    }
}
