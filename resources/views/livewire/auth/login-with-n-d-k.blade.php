<x-jet-authentication-card>

    <x-slot name="logo">
        <x-jet-authentication-card-logo/>
    </x-slot>

    <div>
        <div
            wire:ignore
            x-data="{
                userProfile: @entangle('userProfile'),
                init() {
                    const nip07signer = new window.NDKNip07Signer();
                    const ndk = new window.NDK({
                        explicitRelayUrls: ['wss://nostr.codingarena.de'],
                        signer: nip07signer
                    });

                    ndk.connect();
                },
                login() {
                    nip07signer.user().then(async (user) => {
                        if (!!user.npub) {
                            console.log('user pub: ' + user.npub);
                            const ndkUser = ndk.getUser({
                                npub: user.npub,
                            });
                            await ndkUser.fetchProfile();
                            console.log(ndkUser);
                            this.userProfile = ndkUser.profile;
                        }
                    });
                }
            }"
        >

            <div class="space-y-6" x-init="init()">
                <x-button x-show="!userProfile.npub" primary label="NIP-07 Login" icon="login" @click="login()"/>
                <p x-text="userProfile.npub"></p>
                <p x-text="userProfile.about"></p>
                <img :src="userProfile.image" alt="image"/>
            </div>
        </div>

        @if($existingAccount)
            <div class="mt-12 text-red-500 space-y-6">
                <p>Es existiert ein Account mit dem npub {{ $userProfile['npub'] }}</p>
            </div>
        @endif
    </div>

</x-jet-authentication-card>
