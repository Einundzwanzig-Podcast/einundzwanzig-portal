<?php

namespace App\Http\Controllers;

use App\Models\Meetup;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class DownloadMeetupCalendar extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $meetup = Meetup::query()
                        ->with([
                            'meetupEvents',
                        ])
                        ->findOrFail($request->input('meetup'));

        $entries = [];
        foreach ($meetup->meetupEvents as $event) {
            $entries[] = Event::create()
                              ->name($meetup->name)
                              //->uniqueIdentifier(str($meetup->name)->slug.$event->id)
                              ->address($event->location)
                              ->description($event->description.' Link: '.$event->link)
                              ->image($meetup->getFirstMediaUrl('logo'))
                              ->startsAt($event->start)
                              ->alertMinutesBefore(60 * 2);
        }

        $calendar = Calendar::create()
                            ->name($meetup->name)
                            ->refreshInterval(5)
                            ->event($entries);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8');
    }
}
