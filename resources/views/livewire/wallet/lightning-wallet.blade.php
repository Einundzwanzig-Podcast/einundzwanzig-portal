<x-jet-authentication-card>
    <x-slot name="logo">
        <x-jet-authentication-card-logo/>
    </x-slot>

    <div>

        <div>

            <div class="text-center text-2xl text-gray-800 mt-6">
                Now log in with a new wallet ⚡
            </div>

            <div class="rounded-md bg-red-50 p-4 my-2">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ __('Caution') }}</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                <li>{{ __('You overwrite your user\'s public key and then have to log in with the wallet, which you now use to scan or log in.') }}</li>
                                <li>{{ __('You are logged in as:') }} {{ auth()->user()->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$confirmed)
                <div>
                    <x-button primary wire:click="confirm">
                        <i class="fa-thin fa-check"></i>
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            @endif

            @if($confirmed)
                <div class="flex justify-center" wire:key="qrcode">
                    <a href="lightning:{{ $this->lnurl }}">
                        <img src="{{ 'data:image/png;base64, '. $this->qrCode }}" alt="qrcode">
                    </a>
                </div>
                <div class="my-2 flex justify-center font-mono break-all">
                    <input class="w-full" readonly wire:key="lnurl" onClick="this.select();"
                           value="lightning:{{ $this->lnurl }}"/>
                </div>
                <div class="flex justify-between w-full">
                    <div
                        x-data="{
                      textToCopy: 'lightning:{{ $this->lnurl }}',
                    }"
                        @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('URL copied!') }}',icon:'success'});"
                    >
                        <x-button
                            black
                        >
                            <i class="fa fa-thin fa-clipboard"></i>
                            {{ __('Copy') }}
                        </x-button>
                    </div>
                    <div
                        x-data="{
                      textToCopy: 'lightning:{{ $this->lnurl }}',
                    }"
                        @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('URL copied!') }}',icon:'success'});"
                    >
                        <x-button
                            primary
                            black
                            :href="'lightning:'.$this->lnurl"
                        >
                            {{ __('Click to connect') }}
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                 height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                      d="M461.81 53.81a4.4 4.4 0 00-3.3-3.39c-54.38-13.3-180 34.09-248.13 102.17a294.9 294.9 0 00-33.09 39.08c-21-1.9-42-.3-59.88 7.5-50.49 22.2-65.18 80.18-69.28 105.07a9 9 0 009.8 10.4l81.07-8.9a180.29 180.29 0 001.1 18.3 18.15 18.15 0 005.3 11.09l31.39 31.39a18.15 18.15 0 0011.1 5.3 179.91 179.91 0 0018.19 1.1l-8.89 81a9 9 0 0010.39 9.79c24.9-4 83-18.69 105.07-69.17 7.8-17.9 9.4-38.79 7.6-59.69a293.91 293.91 0 0039.19-33.09c68.38-68 115.47-190.86 102.37-247.95zM298.66 213.67a42.7 42.7 0 1160.38 0 42.65 42.65 0 01-60.38 0z"></path>
                                <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                      d="M109.64 352a45.06 45.06 0 00-26.35 12.84C65.67 382.52 64 448 64 448s65.52-1.67 83.15-19.31A44.73 44.73 0 00160 402.32"></path>
                            </svg>
                        </x-button>
                    </div>
                </div>

                <div class="pt-12" x-show="!currentUser">
                    {{ __('Scan this code or copy & paste it to your lightning wallet. Or click to login with your wallet.') }}
                </div>
            @endif
        </div>

    </div>

    <div wire:poll="checkAuth" wire:key="checkAuth"></div>
</x-jet-authentication-card>
