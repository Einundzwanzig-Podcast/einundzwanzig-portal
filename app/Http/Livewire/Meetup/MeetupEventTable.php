<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\MeetupEvent;
use App\Traits\HasMapEmbedCodeTrait;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use WireUi\Traits\Actions;

class MeetupEventTable extends Component
{
    use Actions;
    use HasMapEmbedCodeTrait;

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
                ->where('visible_on_map', true)
                ->with([
                    'meetup.city.country',
                ])
                ->where('meetup_events.start', '>=', now()->subDay())
                ->whereHas('meetup.city.country',
                    fn($query) => $query->where('countries.code', $this->country->code))
                ->get()
                ->map(fn($event) => [
                    'id' => $event->id,
                    'name' => $event->meetup->name . ': ' . $event->location,
                    'coords' => [$event->meetup->city->latitude, $event->meetup->city->longitude],
                ]),
            'events' => MeetupEvent::query()
                ->with([
                    'meetup.city.country',
                ])
                ->where('meetup_events.start', '>=', now()->subDay())
                ->whereHas('meetup.city.country',
                    fn($query) => $query->where('countries.code', $this->country->code))
                ->get()
                ->map(fn($event) => [
                    'id' => $event->id,
                    'startDate' => $event->start,
                    'endDate' => $event->start->addHours(1),
                    'location' => $event->location,
                    'description' => $event->description,
                ]),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Meetup dates'),
                description: __('List of all meetup dates'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }

    public function filterByMarker($id)
    {
        return to_route('meetup.table.meetupEvent', [
            '#table',
            'country' => $this->country->code,
            'year' => $this->year,
            'meetup_events' => [
                'filters' => [
                    'byid' => $id,
                ],
            ],
        ]);
    }

    public function popover($content, $ids)
    {
        return to_route('meetup.table.meetupEvent', [
            '#table',
            'year' => $this->year,
            'country' => $this->country->code,
            'meetup_events' => [
                'filters' => [
                    'byid' => $ids,
                ],
            ],
        ]);
    }
}
