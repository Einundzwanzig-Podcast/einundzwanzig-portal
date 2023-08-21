<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class LoginWithNDK extends Component
{
    public $existingAccount = false;

    public array $userProfile = [];

    public function rules()
    {
        return [
            'userProfile.npub' => 'required|string',
            'userProfile.pubkey' => 'required|string',

            'userProfile.banner' => 'required|string',
            'userProfile.image' => 'required|string',

            'userProfile.name' => 'required|string',
            'userProfile.username' => 'required|string',
            'userProfile.website' => 'required|string',
            'userProfile.about' => 'required|string',
            'userProfile.displayName' => 'required|string',
            'userProfile.lud16' => 'required|string',
            'userProfile.nip05' => 'required|string',
        ];
    }

    public function updatedUserProfile($value)
    {
        if (User::query()->where('nostr', $value['npub'])->exists()) {
            $this->existingAccount = true;
        }
    }

    public function render()
    {
        return view('livewire.auth.login-with-n-d-k')->layout('layouts.guest');
    }
}
