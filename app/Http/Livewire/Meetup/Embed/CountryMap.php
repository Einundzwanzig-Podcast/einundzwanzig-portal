<?php

namespace App\Http\Livewire\Meetup\Embed;

use App\Models\Country;
use App\Models\Meetup;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CountryMap extends Component
{
    public Country $country;

    public bool $darkMode = false;

    protected $queryString = ['darkMode' => ['except' => false]];

    public function render()
    {
        return view('livewire.meetup.embed.country-map', [
            'markers' => Meetup::query()
                               ->with([
                                   'city.country',
                               ])
                               ->whereHas('city.country',
                                   fn($query) => $query->where('countries.code', $this->country->code))
                               ->get()
                               ->map(fn($meetup) => [
                                   'id'     => $meetup->id,
                                   'name'   => $meetup->name,
                                   'coords' => [$meetup->city->latitude, $meetup->city->longitude],
                                   'url'    => url()->route('meetup.landing', [
                                       'country' => $meetup->city->country->code,
                                       'meetup'  => $meetup,
                                   ]),
                               ]),
        ])->layout('layouts.app', [
            'darkModeDisabled' => !$this->darkMode,
            'SEOData' => new SEOData(
                title: __('Meetups'),
                description: __('Bitcoiner Meetups are a great way to meet other Bitcoiners in your area. You can learn from each other, share ideas, and have fun!'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }
}
