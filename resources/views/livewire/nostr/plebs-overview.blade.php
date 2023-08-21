<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="bg-21gray py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl gap-y-20 gap-x-8 px-6 lg:px-8 xl:grid-cols-3">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-200 sm:text-4xl">{{ __('Follow Einundzwanzig plebs') }}</h2>
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    {{ __('Eine Übersicht aller Einundzwanzig Plebs, die ihren npub geteilt haben.') }}
                </p>
            </div>
            <ul
                wire:ignore
                x-data="{
                    plebsNpubs: @entangle('plebsNpubs'),
                    plebs: [],
                    ndk: null,
                    ndkUser: null,
                    nip07signer: null,
                    async init() {
                        this.ndk = new window.NDK({
                            explicitRelayUrls: ['wss://nos.lol', 'wss://eden.nostr.land', 'wss://relay.damus.io', 'wss://nostr.einundzwanzig.space'],
                        });
                        this.ndk.connect();
                        this.plebsNpubs.forEach(async npub => {
                            const ndkUser = this.ndk.getUser({
                                npub,
                            });
                            await ndkUser.fetchProfile();
                            if (ndkUser.profile.image) {
                                ndkUser.profile.npub = npub;
                                this.plebs.push(ndkUser.profile);
                                console.log(ndkUser.profile);
                            }
                        });
                    },
                }"
                role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">

                <template x-for="pleb in plebs">
                    <li class="text-white cursor-pointer"
                        x-data="{
                            textToCopy: pleb.npub,
                        }"
                        @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('NPUB copied!') }}',icon:'success'});"
                    >
                        <div class="flex items-center gap-x-6">
                            <img class="h-16 w-16 rounded-full"
                                 :src="pleb.image"
                                 :alt="pleb.name">
                            <div>
                                <h3
                                    x-text="pleb.name"
                                    class="text-base font-semibold leading-7 tracking-tight text-gray-200">
                                </h3>
                                <p
                                    x-text="pleb.nip05"
                                    class="text-sm font-semibold leading-6 text-amber-600">
                                </p>
                            </div>
                        </div>
                    </li>
                </template>

            </ul>
        </div>
    </div>

    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
