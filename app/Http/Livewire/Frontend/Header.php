<?php

namespace App\Http\Livewire\Frontend;

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Header extends Component
{
    public Country $country;
    public $currentRouteName;
    public string $c = 'de';
    public bool $withGlobe = true;

    public function rules()
    {
        return [
            'c' => 'required',
        ];
    }

    public function mount()
    {
        $this->currentRouteName = Route::currentRouteName();
        $this->c = $this->country->code;
    }

    public function updatedC($value)
    {
        return to_route($this->currentRouteName, ['country' => $value]);
    }

    public function render()
    {
        return view('livewire.frontend.header', [
            'cities'    => City::query()
                               ->select(['latitude', 'longitude'])
                               ->get(),
            'countries' => Country::query()
                                  ->select(['code', 'name'])
                                  ->get(),
        ]);
    }
}
