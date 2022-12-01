<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use Livewire\Component;

class SearchEvent extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.frontend.search-event');
    }
}
