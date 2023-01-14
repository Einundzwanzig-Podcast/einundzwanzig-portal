<?php

namespace App\Http\Livewire\BookCase;

use App\Models\Country;
use App\Models\User;
use Livewire\Component;

class HighscoreTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.book-case.highscore-table', [
            'plebs' => User::query()
                           ->withCount([
                               'orangePills',
                           ])
                           ->orderByDesc('orange_pills_count')
                           ->get(),
        ]);
    }
}
