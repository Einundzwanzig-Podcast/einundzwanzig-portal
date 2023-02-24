<?php

namespace App\Observers;

use App\Models\CourseEvent;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class CourseEventObserver
{
    use NostrTrait;

    /**
     * Handle the CourseEvent "created" event.
     */
    public function created(CourseEvent $courseEvent): void
    {
        try {
            $this->publishOnNostr($courseEvent, $this->getText('CourseEvent'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the CourseEvent "updated" event.
     */
    public function updated(CourseEvent $courseEvent): void
    {
        //
    }

    /**
     * Handle the CourseEvent "deleted" event.
     */
    public function deleted(CourseEvent $courseEvent): void
    {
        //
    }

    /**
     * Handle the CourseEvent "restored" event.
     */
    public function restored(CourseEvent $courseEvent): void
    {
        //
    }

    /**
     * Handle the CourseEvent "force deleted" event.
     */
    public function forceDeleted(CourseEvent $courseEvent): void
    {
        //
    }
}
