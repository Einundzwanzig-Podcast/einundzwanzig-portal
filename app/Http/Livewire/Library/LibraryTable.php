<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use App\Models\Library;
use App\Models\LibraryItem;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LibraryTable extends Component
{
    public Country $country;
    public array $filters = [];

    public $currentTab = '*';

    protected $queryString = [
        'currentTab' => ['except' => '*'],
        'filters'    => ['except' => ''],
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
                                        ->orderBy('name')
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

        if ($this->currentTab !== '*') {
            $parentLibrary = Library::query()
                                    ->where('name', $this->currentTab)
                                    ->first();
        }

        return view('livewire.library.library-table', [
            'libraries'    => $tabs,
            'libraryItems' => LibraryItem::query()
                                         ->with([
                                             'lecturer',
                                             'tags',
                                         ])
                                         ->when($this->currentTab !== '*', fn($query) => $query
                                             ->whereHas('libraries',
                                                 fn($query) => $query
                                                     ->where('libraries.name', $this->currentTab)
                                             )
                                             ->orWhereHas('libraries',
                                                 fn($query) => $query
                                                     ->where('libraries.parent_id', $parentLibrary->id)
                                             )
                                         )
                                         ->when(count($this->filters) > 0, fn($query) => $query->whereHas('tags',
                                             fn($query) => $query->whereIn('tags.id', $this->filters)))
                                         ->whereHas('libraries',
                                             fn($query) => $query->where('libraries.is_public', $shouldBePublic))
                                         ->get(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Library'),
                description: __('Here you can find all content that are available in the library.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
