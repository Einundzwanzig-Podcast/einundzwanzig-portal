<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Country;
use App\Models\Podcast;
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

        $libraries = \App\Models\Library::query()
                                        ->where('is_public', $shouldBePublic)
                                        ->get();
        $tabs = collect([
            [
                'name' => 'Alle',
            ]
        ]);
        foreach ($libraries as $library) {
            $tabs->push([
                'name' => $library->name,
            ]);
        }

        return view('livewire.frontend.library', [
            'libraries' => $tabs,
        ]);
    }
}
