<?php

namespace App\Livewire\Nostr;

use App\Models\User;
use Livewire\Component;

class Start extends Component
{
    public ?User $user = null;

    public function setUser($value)
    {
        $this->user = User::query()->with(['meetups'])->where('nostr', $value['npub'])->first();
    }

    public function render()
    {
        return view('livewire.nostr.start');
    }
}
