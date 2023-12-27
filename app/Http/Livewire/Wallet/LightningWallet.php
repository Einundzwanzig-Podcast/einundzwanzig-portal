<?php

namespace App\Http\Livewire\Wallet;

use App\Models\LoginKey;
use eza\lnurl;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LightningWallet extends Component
{
    public ?string $k1 = null;
    public ?string $url = null;
    public ?string $lnurl = null;
    public ?string $qrCode = null;

    public bool $confirmed = false;

    public function rules()
    {
        return [
            'k1'     => 'required',
            'url'    => 'required',
            'lnurl'  => 'required',
            'qrCode' => 'required',
        ];
    }

    public function mount()
    {
        $this->k1 = bin2hex(str()->random(32));
        if (app()->environment('local')) {
            $this->url = 'https://einundzwanzig.sharedwithexpose.com/api/lnurl-auth-callback?tag=login&k1='.$this->k1.'&action=login';
        } else {
            $this->url = url('/api/lnurl-auth-callback?tag=login&k1='.$this->k1.'&action=login');
        }
        $this->lnurl = lnurl\encodeUrl($this->url);
        $this->qrCode = base64_encode(QrCode::format('png')
                                            ->size(300)
                                            ->merge('/public/android-chrome-192x192.png', .3)
                                            ->errorCorrection('H')
                                            ->generate($this->lnurl));
    }

    public function confirm()
    {
        $user = auth()->user();
        $user->change = $this->k1;
        $user->change_time = now();
        $user->save();
        $this->confirmed = true;
    }

    public function checkAuth()
    {
        $loginKey = LoginKey::query()
                            ->where('k1', $this->k1)
                            ->whereDate('created_at', '>=', now()->subMinutes(5))
                            ->first();
        // you should also restrict this 👆🏻 by time, and find only the $k1 that were created in the last 5 minutes

        if ($loginKey) {
            return to_route('welcome');
        }
    }

    public function render()
    {
        return view('livewire.wallet.lightning-wallet');
    }
}
