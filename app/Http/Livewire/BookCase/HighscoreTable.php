<?php

namespace App\Http\Livewire\BookCase;

use App\Models\Country;
use App\Models\User;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

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
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Highscore Table'),
                description: __('Hall of fame of our honorable plebs'),
                image: asset('img/highscore_table_screenshot.png'),
            )
        ]);
    }
}
