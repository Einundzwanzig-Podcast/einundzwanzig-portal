<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use App\Models\Country;
use Livewire\Component;

class BookCaseTable extends Component
{
    public string $c = 'de';

    public function render()
    {
        return view('livewire.book-case.book-case-table', [
            'bookCases' => BookCase::get(),
            'countries' => Country::query()
                                  ->select(['code', 'name'])
                                  ->get(),
        ]);
    }
}
