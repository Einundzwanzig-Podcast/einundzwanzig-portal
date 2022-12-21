<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CityTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.school.city-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Courses'),
                description: __('Choose your city, search for courses in the surrounding area and select a topic that suits you.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
