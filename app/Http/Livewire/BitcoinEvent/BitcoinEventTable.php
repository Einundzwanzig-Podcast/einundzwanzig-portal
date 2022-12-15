<?php

namespace App\Http\Livewire\BitcoinEvent;

use App\Models\BitcoinEvent;
use App\Models\Country;
use Livewire\Component;

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
                                     ->where(fn($query) => $query
                                         ->whereHas('venue.city.country',
                                             fn($query) => $query->where('code', $this->country->code))
                                         ->orWhere('show_worldwide', true)
                                     )
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'     => $event->id,
                                         'name'   => $event->title,
                                         'coords' => [$event->venue->city->latitude, $event->venue->city->longitude],
                                     ]),
            'events'  => BitcoinEvent::query()
                                     ->get()
                                     ->map(fn($event) => [
                                         'id'          => $event->id,
                                         'startDate'   => $event->from,
                                         'endDate'     => $event->to,
                                         'location'    => $event->title,
                                         'description' => $event->description,
                                     ]),
        ]);
    }

    public function filterByMarker($id)
    {
        return to_route('bitcoinEvent.table.bitcoinEvent', [
            'country' => $this->country->code,
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
