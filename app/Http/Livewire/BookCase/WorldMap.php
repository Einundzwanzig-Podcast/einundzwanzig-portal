<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use App\Models\Country;
use Livewire\Component;

class WorldMap extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.book-case.world-map', [
            'mapData' => BookCase::query()
                                 ->select(['id', 'latitude', 'longitude'])
                                 ->withCount('orangePills')
                                 ->get()
                                 ->map(fn($bookCase) => [
                                     'lat' => $bookCase->latitude,
                                     'lng' => $bookCase->longitude,
                                     'url' => url()->route('bookCases.table.bookcases',
                                         [
                                             'country'   => $this->country,
                                             'bookcases' => [
                                                 'filters' => [
                                                     'byids' => $bookCase->id,
                                                 ]
                                             ]
                                         ]),
                                     'op'  => $bookCase->orange_pills_count,
                                 ])
                                 ->toArray(),
        ]);
    }
}
