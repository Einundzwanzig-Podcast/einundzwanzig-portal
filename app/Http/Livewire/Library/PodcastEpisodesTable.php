<?php

namespace App\Http\Livewire\Library;

use App\Models\Country;
use App\Models\Episode;
use Livewire\Component;

class PodcastEpisodesTable extends Component
{
    public Country $country;

    public array $filters = [];

    public string $search = '';

    public $perPage = 9;

    public $currentTab = '*';

    protected $queryString = [
        'filters' => ['except' => ''],
        'search'  => ['except' => ''],
    ];

    public function loadMore()
    {
        $this->perPage += 9;
    }

    public function resetFiltering($isLecturerPage = false)
    {
        return to_route('library.table.podcastsEpisodes', ['country' => $this->country]);
    }

    public function render()
    {
        return view('livewire.library.podcast-episodes-table', [
            'episodes' => Episode::query()
                                 ->with(['podcast'])
                                 ->when($this->search,
                                     fn($query, $search) => $query
                                         ->where('data->title', 'ilike', "%{$search}%")
                                         ->orWhere('data->description', 'ilike', "%{$search}%")
                                 )
                                 ->orderByDesc('data->datePublished')
                                 ->paginate($this->perPage),
        ]);
    }
}
