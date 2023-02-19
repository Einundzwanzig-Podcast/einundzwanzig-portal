<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\Meetup;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class WorldMap extends Component
{
    public Country $country;

    public function filterByMarker($id)
    {
        $meetup = Meetup::with(['city.country'])
                        ->find($id);

        return to_route('meetup.landing', [
            'country' => $meetup->city->country->code,
            'meetup' => $meetup,
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
                                  ->map(fn ($meetup) => [
                                      'id' => $meetup->id,
                                      'name' => $meetup->name,
                                      'coords' => [$meetup->city->latitude, $meetup->city->longitude],
                                  ]),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('World map of meetups'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }
}
