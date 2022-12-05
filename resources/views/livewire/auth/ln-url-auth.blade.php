<x-jet-authentication-card>
    <x-slot name="logo">
        <x-jet-authentication-card-logo/>
    </x-slot>

    <div wire:ignore>
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
                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'URL kopiert!',icon:'success'});"
                >
                    <x-button
                        xs
                    >
                        <i class="fa fa-thin fa-clipboard"></i>
                        Kopiere
                    </x-button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-button icon="login" secondary class="ml-4" wire:click="switchToEmailLogin">
                {{ __('Switch to E-Mail login') }}
            </x-button>

            <x-button icon="at-symbol" primary class="ml-4" wire:click="switchToEmailSignup">
                {{ __('Switch to E-Mail signup') }}
            </x-button>

        </div>
    </div>
    <div wire:poll="checkAuth" wire:key="checkAuth"></div>
</x-jet-authentication-card>
