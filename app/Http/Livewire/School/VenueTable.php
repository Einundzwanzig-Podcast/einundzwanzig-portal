<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class VenueTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.school.venue-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Venues'),
                description: __('Venues in the surrounding area.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
