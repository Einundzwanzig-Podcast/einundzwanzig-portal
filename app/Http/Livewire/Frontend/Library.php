<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use Livewire\Component;

class Library extends Component
{
    public Country $country;

    public $currentTab = 'Alle';

    protected $queryString = [
        'currentTab' => ['except' => 'alle'],
    ];

    public function render()
    {
        return view('livewire.frontend.library', [
            'libraries' => \App\Models\Library::query()
                                              ->where('is_public', true)
                                              ->get()
                                              ->prepend(\App\Models\Library::make([
                                                  'name' => 'Alle',
                                              ])),
        ]);
    }
}
