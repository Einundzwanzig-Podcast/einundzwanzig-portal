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
        $shouldBePublic = request()
                              ->route()
                              ->getName() !== 'library.lecturer';
        if (!$shouldBePublic && !auth()->user()->is_lecturer) {
            abort(403);
        }

        return view('livewire.frontend.library', [
            'libraries' => \App\Models\Library::query()
                                              ->where('is_public', $shouldBePublic)
                                              ->get()
                                              ->prepend(\App\Models\Library::make([
                                                  'name' => 'Alle',
                                              ])),
        ]);
    }
}
