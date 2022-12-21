<?php

namespace App\Http\Livewire\BookCase;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CityTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.book-case.city-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Bookcases'),
                description: __('Search out a public bookcase'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
