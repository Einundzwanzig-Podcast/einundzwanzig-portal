<x-jet-authentication-card>
    <x-slot name="logo">
        <x-jet-authentication-card-logo/>
    </x-slot>

    <div wire:ignore>

        <div class="flex items-center justify-end mb-4">
            <x-button icon="arrow-left" secondary class="ml-4" href="/">
                {{ __('Back to the website') }}
            </x-button>
        </div>

        <div>

            <div class="text-center text-2xl text-gray-800 mt-6">
                Login with lightning ⚡
            </div>

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
                        :href="'lightning:'.$this->lnurl"
                    >
                        <i class="fa fa-thin fa-clipboard"></i>
                        {{ __('Click to connect') }}<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M461.81 53.81a4.4 4.4 0 00-3.3-3.39c-54.38-13.3-180 34.09-248.13 102.17a294.9 294.9 0 00-33.09 39.08c-21-1.9-42-.3-59.88 7.5-50.49 22.2-65.18 80.18-69.28 105.07a9 9 0 009.8 10.4l81.07-8.9a180.29 180.29 0 001.1 18.3 18.15 18.15 0 005.3 11.09l31.39 31.39a18.15 18.15 0 0011.1 5.3 179.91 179.91 0 0018.19 1.1l-8.89 81a9 9 0 0010.39 9.79c24.9-4 83-18.69 105.07-69.17 7.8-17.9 9.4-38.79 7.6-59.69a293.91 293.91 0 0039.19-33.09c68.38-68 115.47-190.86 102.37-247.95zM298.66 213.67a42.7 42.7 0 1160.38 0 42.65 42.65 0 01-60.38 0z"></path><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M109.64 352a45.06 45.06 0 00-26.35 12.84C65.67 382.52 64 448 64 448s65.52-1.67 83.15-19.31A44.73 44.73 0 00160 402.32"></path></svg>
                    </x-button>
                </div>
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
            </div>
        </div>

        @if(app()->environment('local'))
            <div class="flex items-center justify-end mt-4">

                <x-button icon="login" secondary class="ml-4" wire:click="switchToEmailLogin">
                    {{ __('Email login') }}
                </x-button>

                <x-button icon="at-symbol" primary class="ml-4" wire:click="switchToEmailSignup">
                    {{ __('Email registration') }}
                </x-button>

            </div>
        @endif

        <div class="pt-12">
            {{ __('Scan this code or copy + paste it to your lightning wallet. Or click to login with your browser\'s wallet.') }}
        </div>
        <div class="pt-2">
            <td
                class="py-1 px-3 text-base leading-6 break-words border border-solid border-collapse border-neutral-600 text-slate-400"
                style="list-style: outside;"
            >
                <a
                    target="_blank"
                    href="https://github.com/getAlby/lightning-browser-extension"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >Alby</a
                >,
                <a
                    target="_blank"
                    href="https://github.com/alexbosworth/balanceofsatoshis"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >Balance of Satoshis</a
                >,
                <a
                    target="_blank" href="https://blixtwallet.github.io" class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                   style="text-decoration: none; list-style: outside;">Blixt</a>,
                <a
                    target="_blank"
                    href="https://breez.technology"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >Breez</a
                >,
                <a
                    target="_blank"
                    href="https://bluewallet.io"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >BlueWallet</a
                >,
                <a
                    target="_blank"
                    href="https://coinos.io"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >coinos</a
                >,
                <a
                    target="_blank"
                    href="https://geyser.fund"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >Geyser</a
                >, <a
                    target="_blank" href="https://lifpay.me"
                      rel="nofollow"
                      class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                      style="text-decoration: none; list-style: outside;">LifPay</a>,
                <a
                    target="_blank"
                    href="https://lnbits.com"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >LNbits</a
                >,
                <a
                    target="_blank"
                    href="https://ln.tips"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >LightningTipBot</a
                >, <a
                    target="_blank" href="https://phoenix.acinq.co"
                      rel="nofollow"
                      class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                      style="text-decoration: none; list-style: outside;">Phoenix</a>,
                <a
                    target="_blank"
                    href="https://seedauth.etleneum.com/"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >SeedAuth</a
                >,
                <a
                    target="_blank"
                    href="https://github.com/pseudozach/seedauthextension"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >SeedAuthExtension</a
                >,
                <a
                    target="_blank"href="https://lightning-wallet.com"
                   rel="nofollow"
                   class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                   style="text-decoration: none; list-style: outside;">SimpleBitcoinWallet</a>,
                <a
                    target="_blank" href="https://sparrowwallet.com/"
                   rel="nofollow"
                   class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                   style="text-decoration: none; list-style: outside;">Sparrow Wallet</a>,
                <a
                    target="_blank"
                    href="https://www.thunderhub.io"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >ThunderHub</a
                >,
                <a
                    target="_blank"
                    href="https://zaphq.io/"
                    rel="nofollow"
                    class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                    style="text-decoration: none; list-style: outside;"
                >Zap Desktop</a
                >, <a
                    target="_blank" href="https://zeusln.app"
                      rel="nofollow"
                      class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                      style="text-decoration: none; list-style: outside;">Zeus</a>
            </td>

        </div>

        <div class="pt-12">
            <p class="text-xs">{{ __('Zeus bug:') }} <a target="_blank"
                                                        href="https://github.com/ZeusLN/zeus/issues/1045">https://github.com/ZeusLN/zeus/issues/1045</a>
            </p>
        </div>
    </div>
    <div wire:poll="checkAuth" wire:key="checkAuth"></div>
</x-jet-authentication-card>
