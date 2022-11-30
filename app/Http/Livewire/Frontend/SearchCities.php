<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use Livewire\Component;

class SearchCities extends Component
{
    public Country $country;
    public string $c = 'de';

    public function rules()
    {
        return [
            'c' => 'required',
        ];
    }

    public function mount()
    {
        $this->c = $this->country->code;
    }

    public function updatedC($value)
    {
        return to_route('search.cities', ['country' => $value]);
    }

    public function render()
    {
        return view('livewire.frontend.search-cities');
    }
}
