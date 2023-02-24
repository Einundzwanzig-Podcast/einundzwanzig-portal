<?php

namespace App\Traits;

use App\Models\BitcoinEvent;
use App\Models\Course;
use App\Models\LibraryItem;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use App\Models\OrangePill;
use App\Nova\CourseEvent;
use Illuminate\Support\Facades\Process;

trait NostrTrait
{
    public function publishOnNostr($model, $text): array
    {
        //noscl publish "Good morning!"
        $result = Process::timeout(60 * 5)
                         ->run('noscl publish "'.$text.'"');

        if ($result->successful()) {
            $model->nostr_status = $result->output();
            $model->save();
        }

        return [
            'success'     => $result->successful(),
            'output'      => $result->output(),
            'exitCode'    => $result->exitCode(),
            'errorOutput' => $result->errorOutput()
        ];
    }

    public function getText($model, $from = null)
    {
        if ($model instanceof BitcoinEvent) {
            return sprintf("Ein neues Event wurde eingestellt:\n\n%s\n\n%s bis %s\n\n%s\n\n%s\n\n#Bitcoin #Event #Einundzwanzig #gesundesgeld",
                $model->title,
                $model->from->asDateTime(),
                $model->to->asDateTime(),
                $model->venue->name,
                $model->link,
            );
        }
        if ($model instanceof CourseEvent) {
            return sprintf("Unser Dozent %s hat einen neuen Kurs-Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $model->course->lecturer->name,
                $model->course->name,
                str($model->course->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $model->course->lecturer]),
            );
        }
        if ($model instanceof MeetupEvent) {
            return sprintf("%s hat einen neuen Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $from,
                $model->start->asDateTime(),
                $model->location,
                url()->route('meetup.event.landing',
                    ['country' => 'de', 'meetupEvent' => $model->id]),
            );
        }
        if ($model instanceof Meetup) {
            return sprintf("Eine neue Meetup Gruppe wurde hinzugefügt:\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $from,
                url()->route('meetup.landing', ['country' => $model->city->country->code, 'meetup' => $model])
            );
        }
        if ($model instanceof Course) {
            return sprintf("Unser Dozent %s hat einen neuen Kurs eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $model->lecturer->name,
                $model->name,
                str($model->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $model->lecturer]),
            );
        }
        if ($model instanceof LibraryItem) {
            return sprintf("Es gibt was Neues zum Lesen oder Anhören:\n\n%s\n\n%s\n\n#Bitcoin #Wissen #Einundzwanzig #gesundesgeld",
                $from,
                url()->route('article.view',
                    ['libraryItem' => $model->slug]),
            );
        }
        if ($model instanceof OrangePill) {
            return sprintf("Ein neues Bitcoin-Buch liegt nun in diesem öffentlichen Bücherschrank:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Education #Einundzwanzig #gesundesgeld",
                $model->bookCase->title,
                $model->bookCase->address,
                url()->route('bookCases.comment.bookcase', ['country' => 'de', 'bookCase' => $model->bookCase]),
            );
        }
    }
}
