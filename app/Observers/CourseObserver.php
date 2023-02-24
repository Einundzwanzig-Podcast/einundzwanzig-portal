<?php

namespace App\Observers;

use App\Models\Course;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class CourseObserver
{
    use NostrTrait;

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
        try {
            $this->publishOnNostr($course, $this->getText('Course'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Course $course): void
    {
        //
    }
}
