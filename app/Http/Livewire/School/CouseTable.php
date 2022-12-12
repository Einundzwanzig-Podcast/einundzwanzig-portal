<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use Livewire\Component;

class CouseTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.school.couse-table');
    }
}
