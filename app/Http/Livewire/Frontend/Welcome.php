<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Welcome extends Component
{
    public string $c = 'de';

    public string $l = 'de';

    protected $queryString = ['c', 'l'];

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
    }

    public function updated($property, $value)
    {
        $this->validate();
        if ($property === 'c') {
            $c = $value;
        } else {
            $c = $this->c;
        }
        if ($property === 'l') {
            $l = $value;
        } else {
            $l = $this->l;
        }

        Cookie::queue('lang', $this->l, 60 * 24 * 365);

        return to_route('welcome', ['c' => $c, 'l' => $l]);
    }

    public function render()
    {
        Cookie::queue('lang', $this->l, 60 * 24 * 365);

        return view('livewire.frontend.welcome', [
            'countries' => Country::query()
                                  ->select('id', 'name', 'code')
                                  ->orderBy('name')
                                  ->get()
                                  ->map(function (Country $country) {
                                      $country->name = config('countries.emoji_flags')[str($country->code)
                                              ->upper()
                                              ->toString()].' '.$country->name;

                                      return $country;
                                  }),
        ])->layout('layouts.guest', [
            'SEOData' => new SEOData(
                title: __('Welcome'),
                description: __('Welcome to the portal of the Einundzwanzig Community.'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }
}
