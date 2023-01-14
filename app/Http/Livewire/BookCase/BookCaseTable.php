<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class BookCaseTable extends Component
{
    public ?Country $country = null;
    public string $c = 'de';
    public array $table = [];

    protected $queryString = ['table'];

    public function render()
    {
        return view('livewire.book-case.book-case-table', [
            'markers'   => BookCase::when($this->table['filters']['byids'] ?? false,
                fn($query) => $query->whereIn('id', str($this->table['filters']['byids'] ?? '')->explode(',')))
                                   ->get()
                                   ->map(fn($b) => [
                                       'title'     => $b->title,
                                       'lat'       => $b->latitude,
                                       'lng'       => $b->longitude,
                                       'url'       => 'https://gonoware.com',
                                       'icon'      => asset('img/btc-logo-6219386_1280.png'),
                                       'icon_size' => [42, 42],
                                   ])
                                   ->toArray(),
            'bookCases' => BookCase::get(),
            'countries' => Country::query()
                                  ->select(['code', 'name'])
                                  ->get(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Bookcases'),
                description: __('Search out a public bookcase'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
