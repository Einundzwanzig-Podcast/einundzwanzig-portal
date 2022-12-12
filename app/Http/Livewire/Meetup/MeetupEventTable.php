<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use Livewire\Component;

class MeetupEventTable extends Component
{
    public Country $country;
    public function render()
    {
        return view('livewire.meetup.meetup-event-table');
    }
}
