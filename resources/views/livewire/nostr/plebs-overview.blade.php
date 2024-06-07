<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="bg-21gray py-24 sm:py-32"
         wire:ignore
         x-data="{
            text: 'Animate',
            char: -1,
            width: '0',
            loading: true,
            loadingFollow: false,
            plebsNpubs: @entangle('plebsNpubs'),
            plebs: [],
            ndk: null,
            search: '',
            ndkUser: null,
            nip07signer: null,
            currentUser: null,
            npubToFollow: null,
            currentFollows: null,
            get searchResults () {
                if (this.search === '') {
                    return this.plebs;
                }

                return this.plebs.filter(
                    i => i.profile && i.profile.name.toLocaleLowerCase().includes(this.search.toLocaleLowerCase())
                );
            },
            async init() {
                $watch('width', value => { if (value > 100) { width = 100 } if (value == 0) { width = 10 } });
                this.ndk = new window.NDK({
                    explicitRelayUrls: [
                        'wss://eden.nostr.land',
                        'wss://relay.snort.social',
                        'wss://nostr.wine',
                        'wss://nostr-pub.wellorder.net',
                        'wss://nos.lol',
                        'wss://offchain.pub',
                        'wss://nostr.fmt.wiz.biz',
                        'wss://nostr.einundzwanzig.space',
                        'wss://relay.nostr.band',
                        'wss://relay.damus.io',
                        'wss://eden.nostr.land',
                        'wss://nostr.codingarena.top',
                        'wss://relay.primal.net',
                    ],
                });
                this.ndk.connect();
                const length = this.plebsNpubs.filter(npub => npub.includes('npub1')).length;
                let counter = 1;
                for (const npub of this.plebsNpubs) {
                    if(npub.includes('npub1')) {
                        const ndkUser = this.ndk.getUser({
                            npub: npub.trim(),
                        });
                        await ndkUser.fetchProfile();
                        if (ndkUser.profile.image) {
                            this.char = -1;
                            this.text = ndkUser.profile.name;
                            this.animate();
                            ndkUser.profile.npub = npub;
                            this.plebs.push(ndkUser);
                            this.width = Math.round(counter / length * 100);
                            counter++;
                        }
                    }
                }
                this.loading = false;
                console.log('LOADING FALSE');
            },
            login () {
                this.nip07signer = new window.NDKNip07Signer();
                this.ndk = new window.NDK({
                    explicitRelayUrls: [
                        'wss://eden.nostr.land',
                        'wss://relay.snort.social',
                        'wss://nostr.wine',
                        'wss://nostr-pub.wellorder.net',
                        'wss://nos.lol',
                        'wss://offchain.pub',
                        'wss://nostr.fmt.wiz.biz',
                        'wss://nostr.einundzwanzig.space',
                        'wss://relay.nostr.band',
                        'wss://relay.damus.io',
                        'wss://eden.nostr.land',
                        'wss://nostr.codingarena.top',
                        'wss://relay.primal.net',
                    ],
                    signer: this.nip07signer
                });
                this.ndk.connect();
                this.nip07signer.user().then(async (user) => {
                    if (!!user.npub) {
                        this.currentUser = this.ndk.getUser({
                            npub: user.npub,
                        });
                        await this.currentUser.fetchProfile();
                        //this.currentFollows = await this.currentUser.follows();
                        //this.plebs.forEach(pleb => {
                        //    console.log(this.currentFollows);
                        //    console.log(this.currentFollows.has(pleb));
                        //});
                    }
                });
            },
            async followAll() {
                this.width = 0;
                this.loadingFollow = true;
                const length = this.plebs.length;
                let counter = 1;
                for (const pleb of this.plebs) {
                    const follow = await this.currentUser.follow(pleb);
                    this.char = -1;
                    this.text = 'Followed ' + pleb.profile.name + '!';
                    this.animate();
                    console.log(follow);
                    this.width = Math.round(counter / length * 100);
                    counter++;
                }
                this.loadingFollow = false;
                window.$wireui.notify({title:'{{ __('Successfully followed all nostr plebs') }}',icon:'success'});
            },
            async follow(npubToFollow) {
                this.followUser = this.ndk.getUser({
                    npub: npubToFollow,
                });
                console.log(this.followUser);
                const follow = await this.currentUser.follow(this.followUser);
                console.log(follow);
                if(follow) {
                    window.$wireui.notify({title:'{{ __('Followed!') }}',icon:'success'});
                } else {
                    window.$wireui.notify({title:'{{ __('Follow failed!') }}',icon:'error'});
                }
            },
            animate() {
                let timer = setInterval(() => {
                    this.char++;
                    if (this.char == this.text.length) {
                        clearInterval(timer);
                        timer = null;
                        return;
                    }
                }, 50);
            }
        }"
    >
        <div class="mx-auto grid max-w-7xl gap-y-20 gap-x-8 px-6 lg:px-8 xl:grid-cols-2">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-200 sm:text-4xl">{{ __('Follow Einundzwanzig plebs') }}</h2>
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    {{ __('An overview of all Einundzwanzig plebs who have shared their npub.') }}
                </p>
                @auth
                    <p class="mt-6 text-lg leading-8 text-gray-300">
                        {{ __('Go to your profile and add your Nostr-npub. After that you can also log in with Nostr here on the portal.') }}
                        <br>
                        <a class="text-amber-500" href="{{ route('profile.show') }}">{{ __('Profile') }}</a>
                    </p>
                @endauth
                <p class="mt-8">
                    <x-button
                        ::disabled="loading"
                        x-show="!currentUser" primary label="{{ __('NIP-07 Login') }}" icon="login"
                        @click="login()"/>
                </p>
                <p class="text-gray-100">
                    <span>{{ __('Log in with your Nostr Extension so you can follow all plebs with one click.') }}</span>
                </p>
                <h3 x-show="currentUser && currentUser.profile" class="py-4 text-gray-100 text-2xl">
                    {{ __('Logged into Nostr as:') }}
                </h3>
                <template x-if="currentUser && currentUser.profile">
                    <div
                        x-show="currentUser && currentUser.profile.image"
                        class="block flex-shrink-0 mt-8">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-9 w-9 rounded-full"
                                     :src="currentUser.profile.image"
                                     :alt="currentUser.profile.image"
                                >
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-100" x-text="currentUser.profile.name"></p>
                                <p class="text-xs font-medium text-gray-200" x-text="currentUser.profile.nip05"></p>
                            </div>
                        </div>
                    </div>
                </template>

            </div>

            <div>
                <div class="py-4 flex space-x-4">
                    <div class="w-1/2">
                        <x-input x-ref="searchInput" x-model="search" placeholder="{{ __('Search') }}"/>
                    </div>
                    <div>
                        <x-button
                            ::disabled="loadingFollow"
                            @click.prevent="followAll()"
                            x-show="currentUser && currentUser.profile"
                        >
                            <i class="fa-thin fa-user-plus mr-2"></i>
                            {{ __('Follow all') }}
                        </x-button>
                    </div>
                </div>

                <div
                    x-show="loading"
                    class="relative block w-full rounded-lg border-2 border-dashed border-purple-300 p-12 text-center hover:border-purple-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <p class="mt-2 block text-lg font-semibold text-amber-500">
                        You should stack sats as long as this page loads here. This is a low time preference loading bar. 🤙
                    </p>
                    <template x-for="(c, i) in text.split('')"><span
                            x-text="c"
                            class="opacity-0 transition ease-in text-2xl text-white"
                            :class="{'opacity-100':char>=i}"></span></template>
                    <div
                        class="bg-purple-200 rounded h-6 mt-5"
                        role="progressbar"
                        :aria-valuenow="width"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <div
                            class="bg-purple-500 rounded h-6 text-center text-white text-sm transition"
                            :style="`width: ${width}%; transition: width 2s;`"
                            x-text="`${width}%`"
                        >
                        </div>
                    </div>
                    <img src="{{ asset('img/running-nostr.gif') }}" alt="running-nostr"
                         class="mt-2 block text-sm font-semibold text-gray-900"/>
                    <span class="mt-2 block text-sm font-semibold text-gray-100">Loadingstr...</span>
                </div>

                <div
                    x-show="loadingFollow"
                    class="relative block w-full rounded-lg border-2 border-dashed border-purple-300 p-12 text-center hover:border-purple-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <p class="mt-2 block text-lg font-semibold text-amber-500">
                        You should stack sats as long as this page loads here. This is a low time preference loading bar. 🤙
                    </p>
                    <template x-for="(c, i) in text.split('')"><span
                            x-text="c"
                            class="opacity-0 transition ease-in text-2xl text-white"
                            :class="{'opacity-100':char>=i}"></span></template>
                    <div
                        class="bg-purple-200 rounded h-6 mt-5"
                        role="progressbar"
                        :aria-valuenow="width"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <div
                            class="bg-purple-500 rounded h-6 text-center text-white text-sm transition"
                            :style="`width: ${width}%; transition: width 2s;`"
                            x-text="`${width}%`"
                        >
                        </div>
                    </div>
                    <img src="{{ asset('img/running-nostr.gif') }}" alt="running-nostr"
                         class="mt-2 block text-sm font-semibold text-gray-900"/>
                    <span class="mt-2 block text-sm font-semibold text-gray-100">Followstr...</span>
                </div>

                <ul role="list" class="divide-y divide-gray-100">

                    <template x-for="pleb in searchResults">
                        <li class="flex items-center justify-between gap-x-6 py-5" x-show="!loading && !loadingFollow">
                            <div class="flex min-w-0 gap-x-4">
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                     :src="pleb.profile.image"
                                     :alt="pleb.profile.name"
                                >
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-100"
                                       x-text="pleb.profile.name"></p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-200"
                                       x-text="pleb.profile.nip05"></p>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <div>
                                    <div
                                        x-data="{
                                        textToCopy: pleb.profile.npub,
                                    }"
                                        @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('NPUB copied!') }}',icon:'success'});"
                                        class="cursor-pointer whitespace-no-wrap rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        Copy
                                    </div>
                                </div>
                                {{--<div>
                                    <div
                                        x-show="currentUser"
                                        @click.prevent="follow(pleb.profile.npub)"
                                        class="cursor-pointer whitespace-no-wrap rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        Follow
                                    </div>
                                </div>--}}
                            </div>
                        </li>
                    </template>

                </ul>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
