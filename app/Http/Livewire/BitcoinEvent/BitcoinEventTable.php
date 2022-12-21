<?php

namespace App\Http\Livewire\BitcoinEvent;

use App\Models\BitcoinEvent;
use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class BitcoinEventTable extends Component
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
        return view('livewire.bitcoin-event.bitcoin-event-table', [
            'markers' => BitcoinEvent::query()
                                     ->with([
                                         'venue.city.country',
                                     ])
                                     ->where('bitcoin_events.from', '>=', now())
                                     ->where(fn($query) => $query
                                         ->whereHas('venue.city.country',
                                             fn($query) => $query->where('countries.code', $this->country->code))
                                         ->orWhere('show_worldwide', true)
                                     )
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'     => $event->id,
                                         'name'   => $event->title,
                                         'coords' => [$event->venue->city->latitude, $event->venue->city->longitude],
                                     ]),
            'events'  => BitcoinEvent::query()
                                     ->where('bitcoin_events.from', '>=', now())
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'          => $event->id,
                                         'startDate'   => $event->from,
                                         'endDate'     => $event->to,
                                         'location'    => $event->title,
                                         'description' => $event->description,
                                     ]),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Bitcoin Events'),
                description: __('Search out a Bitcoin Event'),
                image: asset('img/screenshot.png')
            )
        ]);
    }

    public function filterByMarker($id)
    {
        return to_route('bitcoinEvent.table.bitcoinEvent', [
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
        return to_route('bitcoinEvent.table.bitcoinEvent', [
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
