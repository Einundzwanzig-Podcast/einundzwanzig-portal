<?php

namespace App\Http\Livewire\BookCase;

use App\Models\OrangePill;
use App\Models\User;
use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        return view('livewire.book-case.stats', [
            'orangePills' => OrangePill::query()->count(),
            'plebs' => User::query()->whereHas('orangePills')->count(),
        ]);
    }
}
