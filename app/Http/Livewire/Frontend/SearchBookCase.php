<?php

namespace App\Http\Livewire\Frontend;

use App\Models\BookCase;
use App\Models\Country;
use Livewire\Component;

class SearchBookCase extends Component
{
    public string $c = 'de';

    public function render()
    {
        return view('livewire.frontend.search-book-case', [
            'bookCases' => BookCase::get(),
            'countries' => Country::query()
                                  ->select(['code', 'name'])
                                  ->get(),
        ]);
    }
}
