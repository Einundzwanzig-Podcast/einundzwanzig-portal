<?php

namespace App\Observers;

use App\Models\Course;
use App\Traits\TwitterTrait;

class CourseObserver
{
    use TwitterTrait;

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            $text = sprintf("Unser Dozent %s hat einen neuen Kurs eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $course->lecturer->name,
                $course->name,
                str($course->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $course->lecturer]),
            );

            $this->postTweet($text);
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
