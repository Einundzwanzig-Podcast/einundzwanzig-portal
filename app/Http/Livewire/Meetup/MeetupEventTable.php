<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\MeetupEvent;
use Livewire\Component;
use WireUi\Traits\Actions;

class MeetupEventTable extends Component
{
    use Actions;

    public Country $country;

    public function render()
    {
        return view('livewire.meetup.meetup-event-table', [
            'events' => MeetupEvent::query()
                                   ->get()
                                   ->map(fn($event) => [
                                       'id'          => $event->id,
                                       'startDate'   => $event->start,
                                       'endDate'     => $event->start->endOfDay(),
                                       'location'    => $event->location,
                                       'description' => $event->description,
                                   ]),
        ]);
    }

    public function popover($content, $ids)
    {
        return to_route('meetup.table.meetupEvent', [
            'country' => $this->country->code, 'table' => [
                'filters' => [
                    'byid' => $ids,
                ]
            ]
        ]);
    }
}
