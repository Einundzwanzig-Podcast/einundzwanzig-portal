<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Welcome extends Component
{
    public string $c = 'de';

    protected $queryString = ['c'];

    public function rules()
    {
        return [
            'c' => 'required',
        ];
    }

    public function updated($property, $value)
    {
        $this->validate();

        return to_route('welcome', ['c' => $value]);
    }

    public function render()
    {
        return view('livewire.frontend.welcome', [
            'countries' => Country::get(),
        ])->layout('layouts.guest', [
            'SEOData' => new SEOData(
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
