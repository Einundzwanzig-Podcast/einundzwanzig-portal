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

    public ?int $year = null;

    protected $queryString = ['year'];

    public function mount()
    {
        if (!$this->year) {
            $this->year = now()->year;
        }
    }

    public function render()
    {
        return view('livewire.meetup.meetup-event-table', [
            'markers' => MeetupEvent::query()
                                    ->with([
                                        'meetup.city.country',
                                    ])
                                    ->whereHas('meetup.city.country',
                                        fn($query) => $query->where('countries.code', $this->country->code))
                                    ->get()
                                    ->map(fn($event) => [
                                        'id'     => $event->id,
                                        'name'   => $event->meetup->name.': '.$event->location,
                                        'coords' => [$event->meetup->city->latitude, $event->meetup->city->longitude],
                                    ]),
            'events'  => MeetupEvent::query()
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
    public function filterByMarker($id)
    {
        return to_route('meetup.table.meetupEvent', [
            'country' => $this->country->code,
            'year'    => $this->year,
            'table'   => [
                'filters' => [
                    'byid' => $id,
                ],
            ]
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
