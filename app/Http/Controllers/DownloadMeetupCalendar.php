<?php

namespace App\Http\Controllers;

use App\Models\Meetup;
use App\Models\MeetupEvent;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class DownloadMeetupCalendar extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->has('meetup')) {
            $meetup = Meetup::query()
                            ->with([
                                'meetupEvents',
                            ])
                            ->findOrFail($request->input('meetup'));
            $events = $meetup->meetupEvents;
            $image = $meetup->getFirstMediaUrl('logo');
        } else {
            $events = MeetupEvent::query()
                                 ->with([
                                     'meetup',
                                 ])
                                 ->get();
            $image = asset('img/einundzwanzig-horizontal.png');
        }

        $entries = [];
        foreach ($events as $event) {
            $entries[] = Event::create($event->meetup->name)
                              ->uniqueIdentifier(str($event->meetup->name)->slug().$event->id)
                              ->address($event->location ?? __('no location set'))
                              ->description(str_replace(["\r", "\n"], '', $event->description).' Link: '.$event->link)
                              ->image($image)
                              ->startsAt($event->start);
        }

        $calendar = Calendar::create()
                            ->refreshInterval(5)
                            ->event($entries);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8');
    }
}
