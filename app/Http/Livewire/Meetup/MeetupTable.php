<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\Meetup;
use Livewire\Component;

class MeetupTable extends Component
{
    public Country $country;

    public function render()
    {
        // let markers = [{name: 'VAK', coords: [50.0091294, 9.0371812], status: 'closed', offsets: [0, 2]}];

        return view('livewire.meetup.meetup-table', [
            'markers' => Meetup::query()
                               ->with([
                                   'city.country',
                               ])
                               ->whereHas('city.country',
                                   fn($query) => $query->where('countries.code', $this->country->code))
                               ->get()
                               ->map(fn($meetup) => [
                                   'name'   => $meetup->name,
                                   'coords' => [$meetup->city->latitude, $meetup->city->longitude],
                               ])
        ]);
    }
}
