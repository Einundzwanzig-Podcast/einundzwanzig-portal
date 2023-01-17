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

            <div class="flex justify-center" wire:key="qrcode">
                {!! $this->qrCode !!}
            </div>
            <div class="my-2 flex justify-center font-mono break-all">
                <input class="w-full" readonly wire:key="lnurl" onClick="this.select();"
                       value="lightning:{{ $this->lnurl }}"/>
            </div>
            <div class="flex justify-end w-full">
                <div
                    x-data="{
                      textToCopy: 'lightning:{{ $this->lnurl }}',
                    }"
                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('URL copied!') }}',icon:'success'});"
                >
                    <x-button
                        xs
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
            {{ __('Copy the LNURL and paste it under "Send" or scan the QR code with "Send". LNURL-auth enabled wallets:') }}
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
                >, <a
                    target="_blank" href="https://lntxbot.com"
                      rel="nofollow"
                      class="leading-6 text-blue-400 bg-transparent cursor-pointer"
                      style="text-decoration: none; list-style: outside;">@lntxbot</a>,
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
