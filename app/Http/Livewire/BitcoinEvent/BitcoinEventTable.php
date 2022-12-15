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

    public function render()
    {
        return view('livewire.bitcoin-event.bitcoin-event-table', [
            'events' => BitcoinEvent::query()
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
