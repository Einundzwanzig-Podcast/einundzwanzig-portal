<?php

namespace App\Http\Livewire\BitcoinEvent;

use App\Models\Country;
use Livewire\Component;

class BitcoinEventTable extends Component
{
    public Country $country;
    public function render()
    {
        return view('livewire.bitcoin-event.bitcoin-event-table');
    }
}
