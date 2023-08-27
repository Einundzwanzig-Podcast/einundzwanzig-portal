<?php

namespace App\Http\Livewire\Nostr;

use App\Models\User;
use Livewire\Component;

class PlebsOverview extends Component
{
    public array $plebsNpubs = [];

    public function mount()
    {
        $this->plebsNpubs = User::query()
            ->select([
                'email',
                'public_key',
                'lightning_address',
                'lnurl',
                'node_id',
                'paynym',
                'lnbits',
                'nostr',
                'id',
            ])
            ->whereNotNull('nostr')
            ->orderByDesc('id')
            ->get()
            ->unique('nostr')
            ->pluck('nostr')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.nostr.plebs-overview');
    }
}
