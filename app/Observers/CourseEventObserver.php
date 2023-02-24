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
            $text = sprintf("Unser Dozent %s hat einen neuen Kurs-Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $courseEvent->course->lecturer->name,
                $courseEvent->course->name,
                str($courseEvent->course->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $courseEvent->course->lecturer]),
            );

            $this->publishOnNostr($courseEvent, $text);
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
