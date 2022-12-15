<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\Meetup;
use Livewire\Component;

class WorldMap extends Component
{
    public Country $country;

    public function filterByMarker($id)
    {
        $meetup = Meetup::with(['city.country'])
                        ->find($id);

        return to_route('meetup.table.meetup', [
            'country' => $meetup->city->country->code,
            'table'   => [
                'filters' => [
                    'byid' => $id,
                ],
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.meetup.world-map', [
            'allMarkers' => Meetup::query()
                                  ->with([
                                      'city.country',
                                  ])
                                  ->get()
                                  ->map(fn($meetup) => [
                                      'id'     => $meetup->id,
                                      'name'   => $meetup->name,
                                      'coords' => [$meetup->city->latitude, $meetup->city->longitude],
                                  ]),
        ]);
    }
}
