<?php

namespace App\Observers;

use App\Models\Course;
use App\Traits\TwitterTrait;

class CourseObserver
{
    use TwitterTrait;

    /**
     * Handle the Course "created" event.
     *
     * @param  \App\Models\Course  $course
     *
     * @return void
     */
    public function created(Course $course)
    {
        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            $text = sprintf("Unser Dozent %s hat einen neuen Kurs eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig",
                $course->lecturer->name,
                $course->name,
                str($course->description)->limit(100),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $course->lecturer]),
            );

            $this->postTweet($text);
        }
    }

    /**
     * Handle the Course "updated" event.
     *
     * @param  \App\Models\Course  $course
     *
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }

    /**
     * Handle the Course "deleted" event.
     *
     * @param  \App\Models\Course  $course
     *
     * @return void
     */
    public function deleted(Course $course)
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     *
     * @param  \App\Models\Course  $course
     *
     * @return void
     */
    public function restored(Course $course)
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     *
     * @param  \App\Models\Course  $course
     *
     * @return void
     */
    public function forceDeleted(Course $course)
    {
        //
    }
}
