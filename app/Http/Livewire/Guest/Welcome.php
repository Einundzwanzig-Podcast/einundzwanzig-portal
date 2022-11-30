<?php

namespace App\Http\Livewire\Guest;

use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        return view('livewire.guest.welcome')->layout('layouts.guest');
    }
}
