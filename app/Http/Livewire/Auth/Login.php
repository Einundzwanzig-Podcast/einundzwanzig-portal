<?php

namespace App\Http\Livewire\Auth;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class Login extends Component
{
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
        if ($value['npub']) {
            $firstUser = User::query()->where('nostr', $value['npub'])->first();
            if ($firstUser) {
                auth()->login($firstUser, true);

                return to_route('welcome');
            } else {
                $fakeName = str()->random(10);
                // create User
                $user = User::create([
                    'is_lecturer' => true,
                    'name' => $fakeName,
                    'email' => str($fakeName)->slug() . '@portal.einundzwanzig.space',
                    'email_verified_at' => now(),
                    'lnbits' => [
                        'read_key' => null,
                        'url' => null,
                        'wallet_id' => null,
                    ],
                    'nostr' => $value['npub'],
                ]);
                $user->ownedTeams()
                    ->save(Team::forceCreate([
                        'user_id' => $user->id,
                        'name' => $fakeName . "'s Team",
                        'personal_team' => true,
                    ]));
                auth()->login($user, true);

                return to_route('welcome');
            }
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
