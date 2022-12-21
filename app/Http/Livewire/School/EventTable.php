<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use App\Models\CourseEvent;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class EventTable extends Component
{
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
        return view('livewire.school.event-table', [
            'markers' => CourseEvent::query()
                                     ->with([
                                         'course',
                                         'venue.city.country',
                                     ])
                                     ->where(fn($query) => $query
                                         ->whereHas('venue.city.country',
                                             fn($query) => $query->where('countries.code', $this->country->code))
                                     )
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'     => $event->id,
                                         'name'   => $event->course->name,
                                         'coords' => [$event->venue->city->latitude, $event->venue->city->longitude],
                                     ]),
            'events'  => CourseEvent::query()
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'          => $event->id,
                                         'startDate'   => $event->from,
                                         'endDate'     => $event->to,
                                         'location'    => $event->course->name,
                                         'description' => $event->venue->name,
                                     ]),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Dates'),
                description: __('Dates for courses about Bitcoin.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }

    public function filterByMarker($id)
    {
        return to_route('school.table.event', [
            '#table',
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
        return to_route('school.table.event', [
            '#table',
            'country' => $this->country->code,
            'year'    => $this->year,
            'table'   => [
                'filters' => [
                    'byid' => $ids,
                ]
            ]
        ]);
    }
}
