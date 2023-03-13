<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     */
    public function update($user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lightning_address' => ['nullable', 'string'],
            'lnurl' => ['nullable', 'string'],
            'nostr' => ['nullable', 'string'],
            'node_id' => ['nullable', 'string', 'max:66'],
            'timezone' => ['required', 'string'],
            'email' => [
                'nullable', 'email', 'max:255', Rule::unique('users')
                                                    ->ignore($user->id),
            ],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
        ])
                 ->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'lightning_address' => $input['lightning_address'],
                'lnurl' => $input['lnurl'],
                'nostr' => $input['nostr'],
                'node_id' => $input['node_id'],
                'email' => $input['email'],
                'timezone' => $input['timezone'],
                'lnbits' => $user->lnbits ?? [],
            ])
                 ->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     */
    protected function updateVerifiedUser($user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'lightning_address' => $input['lightning_address'],
            'lnurl' => $input['lnurl'],
            'node_id' => $input['node_id'],
            'nostr' => $input['nostr'],
            'email' => $input['email'],
            'timezone' => $input['timezone'],
            'email_verified_at' => null,
            'lnbits' => $user->lnbits ?? [],
        ])
             ->save();

        $user->sendEmailVerificationNotification();
    }
}
