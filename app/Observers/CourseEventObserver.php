<?php

namespace App\Observers;

use App\Models\CourseEvent;
use App\Traits\TwitterTrait;

class CourseEventObserver
{
    use TwitterTrait;

    /**
     * Handle the CourseEvent "created" event.
     */
    public function created(CourseEvent $courseEvent): void
    {
        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            $text = sprintf("Unser Dozent %s hat einen neuen Kurs-Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $courseEvent->course->lecturer->name,
                $courseEvent->course->name,
                str($courseEvent->course->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $courseEvent->course->lecturer]),
            );

            $this->postTweet($text);
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
