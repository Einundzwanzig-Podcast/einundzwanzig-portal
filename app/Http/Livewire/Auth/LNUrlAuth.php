<?php

namespace App\Http\Livewire\Auth;

use App\Models\LoginKey;
use App\Models\User;
use eza\lnurl;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LNUrlAuth extends Component
{
    protected ?string $k1 = null;
    protected ?string $lnurl = null;
    protected ?string $qrCode = null;

    public function switchToEmail()
    {
        dd('test');
    }

    public function mount()
    {
        $this->k1 = bin2hex(str()->random(32));
        $this->lnurl = lnurl\encodeUrl(url('/lnurl-auth-callback',
            ['tag' => 'login', 'k1' => $this->k1, 'action' => 'login']));
        $this->qrCode = QrCode::size(300)
                              ->generate($this->lnurl);
    }

    public function checkAuth()
    {
        $loginKey = LoginKey::where('k1', $this->k1)
                            ->where('created_at', '<=', now()->subMinutes(5))
                            ->first();
        // you should also restrict this 👆🏻 by time, and find only the $k1 that were created in the last 5 minutes

        if ($loginKey) {
            $user = User::find($loginKey->user_id);
            auth()->login($user);
            return to_route('welcome');
        }

        return true;
    }

    public function render()
    {
        return view('livewire.auth.ln-url-auth')->layout('layouts.guest');
    }
}
