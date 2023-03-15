<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use App\Models\Library;
use App\Models\LibraryItem;
use App\Models\Tag;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LibraryTable extends Component
{
    public Country $country;

    public array $filters = [];

    public bool $isLecturerPage = false;

    public string $search = '';

    public $perPage = 9;

    public $currentTab = '*';

    protected $queryString = [
        'currentTab' => ['except' => '*'],
        'filters'    => ['except' => ''],
        'search'     => ['except' => ''],
    ];

    public function loadMore()
    {
        $this->perPage += 9;
    }

    public function mount()
    {
        if (str(request()
            ->route()
            ->getName())->contains(['.lecturer'])) {
            $this->isLecturerPage = true;
        }
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
            ],
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
        $searchTags = [];
        if ($this->search) {
            $searchTags = Tag::where('name', 'ilike', '%'.$this->search.'%')
                             ->pluck('id')
                             ->toArray();
        }

        return view('livewire.library.library-table', [
            'libraries'    => $tabs,
            'libraryItems' => LibraryItem::query()
                                         ->with([
                                             'lecturer',
                                             'tags',
                                         ])
                                         ->when($this->search, fn($query) => $query
                                             ->where('name', 'ilike', '%'.$this->search.'%')
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
                                         ->when(isset($this->filters['lecturer_id']),
                                             fn($query) => $query->where('library_items.lecturer_id',
                                                 $this->filters['lecturer_id'])
                                         )
                                         ->when(isset($this->filters['tag']), fn($query) => $query->whereHas('tags',
                                             fn($query) => $query->whereIn('tags.id', $this->filters['tag'])))
                                         ->when(isset($this->filters['language']),
                                             fn($query) => $query->whereIn('language_code', $this->filters['language']))
                                         ->whereHas('libraries',
                                             fn($query) => $query->where('libraries.is_public', $shouldBePublic))
                                         ->orderByDesc('library_items.created_at')
                                         ->paginate($this->perPage),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Library'),
                description: __('Here you can find all content that are available in the library.'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }
}
