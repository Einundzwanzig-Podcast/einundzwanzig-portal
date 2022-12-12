<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use Livewire\Component;

class EventTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.school.event-table');
    }
}
