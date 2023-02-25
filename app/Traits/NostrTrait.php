<?php

namespace App\Traits;

use App\Models\BitcoinEvent;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\LibraryItem;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use App\Models\OrangePill;
use Illuminate\Support\Facades\Process;

trait NostrTrait
{
    public function publishOnNostr($model, $text): array
    {
        if (app()->environment('local')) {
            return [
                'success'     => true,
                'output'      => 'local',
                'exitCode'    => 0,
                'errorOutput' => ''
            ];
        }

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

    public function getText($model)
    {
        $from = '';
        if ($model instanceof BitcoinEvent) {
            return sprintf("Ein neues Event wurde eingestellt:\n%s\n%s bis %s\n%s\n%s\n\n#Bitcoin #Event #Einundzwanzig #gesundesgeld",
                $model->title,
                $model->from->asDateTime(),
                $model->to->asDateTime(),
                $model->venue->name,
                $model->link,
            );
        }
        if ($model instanceof CourseEvent) {
            if ($model->course->lecturer->nostr) {
                $from .= '@'.$model->course->lecturer->nostr;
            } else {
                $from .= $model->lecturer->name;
            }

            return sprintf("Unser Dozent %s hat einen neuen Kurs-Termin eingestellt:\n%s\n%s\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $from,
                $model->course->name,
                str($model->course->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $model->course->lecturer]),
            );
        }
        if ($model instanceof MeetupEvent) {
            $from = $model->meetup->name;
            if ($model->meetup->nostr) {
                $from .= ' @'.$model->meetup->nostr;
            }

            return sprintf("%s hat einen neuen Termin eingestellt:\n%s\n%s\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $from,
                $model->start->asDateTime(),
                $model->location,
                url()->route('meetup.event.landing',
                    ['country' => 'de', 'meetupEvent' => $model->id]),
            );
        }
        if ($model instanceof Meetup) {
            $from = $model->name;
            if ($model->nostr) {
                $from .= ' @'.$model->nostr;
            }

            return sprintf("Eine neue Meetup Gruppe wurde hinzugefügt:\n%s\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $from,
                url()->route('meetup.landing', ['country' => $model->city->country->code, 'meetup' => $model])
            );
        }
        if ($model instanceof Course) {
            if ($model->lecturer->nostr) {
                $from .= '@'.$model->lecturer->nostr;
            } else {
                $from .= $model->lecturer->name;
            }

            return sprintf("Unser Dozent %s hat einen neuen Kurs eingestellt:\n%s\n%s\n%s\n\n#Bitcoin #Kurs #Education #Einundzwanzig #gesundesgeld",
                $from,
                $model->name,
                str($model->description)->limit(80),
                url()->route('school.landingPage.lecturer',
                    ['country' => 'de', 'lecturer' => $model->lecturer]),
            );
        }
        if ($model instanceof LibraryItem) {
            $from = $model->name;
            if ($model->lecturer->nostr) {
                $from .= ' von @'.$model->lecturer->nostr;
            } else {
                $from .= ' von '.$model->lecturer->name;
            }

            return sprintf("Es gibt was Neues zum Lesen oder Anhören:\n%s\n%s\n\n#Bitcoin #Wissen #Einundzwanzig #gesundesgeld",
                $from,
                url()->route('article.view',
                    ['libraryItem' => $model->slug]),
            );
        }
        if ($model instanceof OrangePill) {
            return sprintf("Ein neues Bitcoin-Buch liegt nun in diesem öffentlichen Bücherschrank:\n%s\n%s\n%s\n\n#Bitcoin #Education #Einundzwanzig #gesundesgeld",
                $model->bookCase->title,
                $model->bookCase->address,
                url()->route('bookCases.comment.bookcase', ['country' => 'de', 'bookCase' => $model->bookCase]),
            );
        }
    }
}
