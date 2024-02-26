<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Auth47Component extends Component
{
    public ?string $k1 = null;

    protected ?string $url = null;

    public function mount()
    {
        $this->k1 = bin2hex(str()->random(32));
        $this->url = 'auth47://'.$this->k1.'?c=https://einundzwanzig.sharedwithexpose.com/auth/auth47-callback&r=https://einundzwanzig.eu-1.sharedwithexpose.com/auth/auth47-callback';
        $this->qrCode = base64_encode(QrCode::format('png')
                                            ->size(600)
                                            ->errorCorrection('L')
                                            ->generate($this->url));
    }

    public function render()
    {
        return view('livewire.auth.auth47-component')->layout('layouts.guest');
    }
}
