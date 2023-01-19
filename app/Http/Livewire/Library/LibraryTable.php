<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LibraryTable extends Component
{
    public Country $country;

    public $currentTab = '*';

    protected $queryString = [
        'currentTab' => ['except' => '*'],
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
                                        ->whereNull('parent_id')
                                        ->where('is_public', $shouldBePublic)
                                        ->get();
        $tabs = collect([
            [
                'name' => '*',
            ]
        ]);
        foreach ($libraries as $library) {
            $tabs->push([
                'name' => $library->name,
            ]);
        }

        return view('livewire.library.library-table', [
            'libraries' => $tabs,
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Library'),
                description: __('Here you can find all content that are available in the library.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
