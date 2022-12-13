<?php

namespace App\Http\Livewire\BookCase;

use App\Models\Country;
use Livewire\Component;

class CityTable extends Component
{
    public Country $country;
    public function render()
    {
        return view('livewire.book-case.city-table');
    }
}
