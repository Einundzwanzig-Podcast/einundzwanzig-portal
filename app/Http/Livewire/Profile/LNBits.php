<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use WireUi\Traits\Actions;

class LNBits extends Component
{
    use Actions;

    public array $settings = [
        'url'       => 'https://legend.lnbits.com',
        'wallet_id' => '',
        'read_key'  => '',
    ];

    public function rules()
    {
        return [
            'settings.url'       => 'required|url',
            'settings.wallet_id' => 'required',
            'settings.read_key'  => 'required',
        ];
    }

    public function mount()
    {
        if (auth()->user()->lnbits) {
            $this->settings = auth()->user()->lnbits;
        }
    }

    public function save()
    {
        $this->validate();
        $user = auth()->user();
        $user->lnbits = $this->settings;
        $user->save();

        $this->notification()
             ->success(__('LNBits settings saved successfully!'));
    }

    public function render()
    {
        return view('livewire.profile.l-n-bits');
    }
}
