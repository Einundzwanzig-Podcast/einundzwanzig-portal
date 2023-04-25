<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use App\Models\Country;
use App\Traits\HasTextToSpeech;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class WorldMap extends Component
{
    use HasTextToSpeech;

    public Country $country;

    public function render()
    {
        return view('livewire.book-case.world-map', [
            'mapData' => BookCase::query()
                                 ->select(['id', 'latitude', 'longitude'])
                                 ->withCount('orangePills')
                                 ->active()
                                 ->get()
                                 ->map(fn ($bookCase) => [
                                     'lat' => $bookCase->latitude,
                                     'lng' => $bookCase->longitude,
                                     'url' => url()->route('bookCases.comment.bookcase',
                                         [
                                             'country' => $this->country,
                                             'bookCase' => $bookCase,
                                         ]),
                                     'op' => $bookCase->orange_pills_count,
                                 ])
                                 ->toArray(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('World Map of Bookcases'),
                description: __('On this map you can see bookcases that have been orange pilled. You can also click on a marker to go to the search result.'),
                image: asset('img/world_map_bookcases.png')
            ),
        ]);
    }
}
