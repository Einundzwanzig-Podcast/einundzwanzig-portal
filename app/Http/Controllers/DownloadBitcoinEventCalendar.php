<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\BitcoinEvent;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class DownloadBitcoinEventCalendar extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $events = BitcoinEvent::query()
                              ->with([
                                  'venue.city.country',
                              ])
                              ->get();

        $entries = [];
        foreach ($events as $event) {
            $entries[] = Event::create()
                              ->name($event->title)
                              ->uniqueIdentifier(str($event->title)->slug().$event->id)
                              ->address($event->venue->name.', '.$event->venue->street.', '.$event->venue->city->name.', '.$event->venue->city->country->name)
                              ->description(str_replace(["\r", "\n"], '', $event->description).' Link: '.$event->link)
                              ->image($event->getFirstMediaUrl('logo'))
                              ->startsAt($event->from)
                              ->endsAt($event->to);
        }

        $calendar = Calendar::create()
                            ->name(__('Bitcoin Events'))
                            ->refreshInterval(5)
                            ->event($entries);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8');
    }
}
