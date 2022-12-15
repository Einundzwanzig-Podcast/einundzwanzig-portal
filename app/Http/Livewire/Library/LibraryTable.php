<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use App\Models\Podcast;
use Livewire\Component;

class LibraryTable extends Component
{
    public Country $country;

    public $currentTab = 'Alle';

    protected $queryString = [
        'currentTab' => ['except' => 'Alle'],
    ];

    public function render()
    {
        $shouldBePublic = request()
                              ->route()
                              ->getName() !== 'library.table.lecturer';
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

        return view('livewire.library.library-table', [
            'libraries' => $tabs,
        ]);
    }
}
