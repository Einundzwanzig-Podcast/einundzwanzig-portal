<?php

namespace App\Http\Livewire\Frontend;

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Header extends Component
{
    public ?Country $country = null;
    public $currentRouteName;
    public string $c = 'de';
    public string $l = 'de';

    protected $queryString = ['l'];

    public function rules()
    {
        return [
            'c' => 'required',
            'l' => 'required',
        ];
    }

    public function mount()
    {
        $this->l = Cookie::get('lang') ?: config('app.locale');
        if (!$this->country) {
            $this->country = Country::query()
                                    ->where('code', $this->c)
                                    ->first();
        }
        $this->currentRouteName = Route::currentRouteName();
        $this->c = $this->country->code;
    }

    public function updatedC($value)
    {
        return to_route($this->currentRouteName, ['country' => $value, 'lang' => $this->l]);
    }

    public function updatedL($value)
    {
        Cookie::queue('lang', $this->l, 60 * 24 * 365);

        return to_route($this->currentRouteName, ['country' => $this->c, 'l' => $value]);
    }

    public function render()
    {
        Cookie::queue('lang', $this->l, 60 * 24 * 365);

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
