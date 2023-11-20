<?php

namespace App\Livewire\Nostr;

use App\Models\Meetup;
use App\Models\User;
use Livewire\Component;

class Start extends Component
{
    public ?User $user = null;
    public array $geoJsons = [];

    public function setUser($value)
    {
        $this->user = User::query()
            ->with([
                'meetups.city',
            ])
            ->where('nostr', $value['npub'])
            ->first();

        $this->geoJsons = Meetup::query()
            ->with([
                'city',
            ])
            ->get()
            ->pluck('city.simplified_geojson')
            ->filter()
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.nostr.start');
    }
}
