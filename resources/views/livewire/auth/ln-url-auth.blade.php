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
            <p class="text-xs">{{ __('Zeus bug:') }} <a target="_blank"
                                                        href="https://github.com/ZeusLN/zeus/issues/1045">https://github.com/ZeusLN/zeus/issues/1045</a>
            </p>
        </div>
    </div>
    <div wire:poll="checkAuth" wire:key="checkAuth"></div>
</x-jet-authentication-card>
