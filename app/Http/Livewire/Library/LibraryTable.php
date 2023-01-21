<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use App\Models\Library;
use App\Models\LibraryItem;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LibraryTable extends Component
{
    public Country $country;
    public array $filters = [];
    public Collection $libraryItems;
    public bool $isLecturerPage = false;

    public string $search = '';

    public $currentTab = '*';

    protected $queryString = [
        'currentTab' => ['except' => '*'],
        'filters'    => ['except' => ''],
        'search'     => ['except' => ''],
    ];

    public function mount()
    {
        if (str(request()
            ->route()
            ->getName())->contains(['.lecturer'])) {
            $this->isLecturerPage = true;
        }
        $this->loadLibraryItems($this->search);
    }

    public function loadLibraryItems($term = null)
    {
        $shouldBePublic = !$this->isLecturerPage;
        if (!$shouldBePublic && !auth()->user()->is_lecturer) {
            abort(403);
        }

        if ($this->currentTab !== '*') {
            $parentLibrary = Library::query()
                                    ->where('name', $this->currentTab)
                                    ->first();
        }

        $searchTags = [];
        if ($term) {
            $searchTags = Tag::where('name', 'ilike', '%'.$term.'%')
                             ->pluck('id')
                             ->toArray();
        }

        $this->libraryItems = LibraryItem::query()
                                         ->with([
                                             'lecturer',
                                             'tags',
                                         ])
                                         ->when($term, fn($query) => $query
                                             ->where('name', 'ilike', '%'.$term.'%')
                                             ->orWhere(fn($query) => $query
                                                 ->when(count($searchTags) > 0 && count($this->filters) < 1,
                                                     fn($query) => $query->whereHas('tags',
                                                         fn($query) => $query->whereIn('tags.id', $searchTags)))
                                             )
                                         )
                                         ->when($this->currentTab !== '*', fn($query) => $query
                                             ->whereHas('libraries',
                                                 fn($query) => $query
                                                     ->where('libraries.name', $this->currentTab)
                                             )
                                         )
                                         ->when(count($this->filters) > 0, fn($query) => $query->whereHas('tags',
                                             fn($query) => $query->whereIn('tags.id', $this->filters)))
                                         ->whereHas('libraries',
                                             fn($query) => $query->where('libraries.is_public', $shouldBePublic))
                                         ->orderByDesc('library_items.created_at')
                                         ->get();
    }

    public function updatedSearch($value)
    {
        $this->loadLibraryItems($value);
    }

    public function resetFiltering($isLecturerPage = false)
    {
        if ($isLecturerPage) {
            return to_route('library.table.lecturer', ['country' => $this->country, 'currentTab' => '*']);
        } else {
            return to_route('library.table.libraryItems', ['country' => $this->country, 'currentTab' => '*']);
        }
    }

    public function render()
    {
        $shouldBePublic = !$this->isLecturerPage;
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
