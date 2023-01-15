<?php

namespace App\Http\Livewire\Auth;

use App\Gamify\Points\LoggedIn;
use App\Models\LoginKey;
use App\Models\User;
use App\Notifications\ModelCreatedNotification;
use eza\lnurl;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LNUrlAuth extends Component
{
    public ?string $k1 = null;
    protected ?string $url = null;
    protected ?string $lnurl = null;
    protected ?string $qrCode = null;

    public function switchToEmailLogin()
    {
        return to_route('login');
    }

    public function switchToEmailSignup()
    {
        return to_route('register');
    }

    public function mount()
    {
        $this->k1 = bin2hex(str()->random(32));
        $this->url = url('/api/lnurl-auth-callback?tag=login&k1='.$this->k1.'&action=login');
        $this->lnurl = lnurl\encodeUrl($this->url);
        $this->qrCode = QrCode::size(300)
                              ->generate($this->lnurl);
    }

    public function checkAuth()
    {
        $loginKey = LoginKey::query()
                            ->where('k1', $this->k1)
                            ->whereDate('created_at', '>=', now()->subMinutes(5))
                            ->first();
        // you should also restrict this 👆🏻 by time, and find only the $k1 that were created in the last 5 minutes

        if ($loginKey) {
            $user = User::find($loginKey->user_id);

            \App\Models\User::find(1)
                            ->notify(new ModelCreatedNotification($user, 'users'));

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
