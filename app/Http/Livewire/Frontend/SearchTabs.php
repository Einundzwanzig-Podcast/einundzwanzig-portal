<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class SearchTabs extends Component
{
    public string $country;

    public function render()
    {
        return view('livewire.frontend.search-tabs');
    }
}
