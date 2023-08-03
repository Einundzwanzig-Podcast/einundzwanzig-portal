<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>
    <div class="flex flex-col">
        <section class="">
            <div class="px-10 pt-6 mx-auto max-w-7xl">
                <div class="w-full mx-auto text-left md:text-center">
                    <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-900 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                    <span
                        class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-500 lg:inline">{{ __('LNBits') }}</span>
                    </h1>
                    <p class="px-0 mb-6 text-lg text-gray-200 md:text-xl lg:px-24">
                        {{ __('Enter the data of your LNBits instance here to receive sats for articles, for example.') }}
                    </p>
                </div>
            </div>
        </section>

        <div class="container p-4 mx-auto bg-21gray my-2">

            <form class="space-y-8 divide-y divide-gray-700 pb-24">
                <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                        <x-input.group :for="md5('settings.url')" :label="__('LNBits Url')">
                            <x-input autocomplete="off" wire:model.debounce="settings.url"
                                     :placeholder="__('LNBits Url')"/>
                        </x-input.group>

                        <x-input.group :for="md5('settings.wallet_id')" :label="__('Wallet ID')">
                            <x-input autocomplete="off" wire:model.debounce="settings.wallet_id"
                                     :placeholder="__('Wallet ID')"/>
                        </x-input.group>

                        <x-input.group :for="md5('settings.read_key')" :label="__('Invoice/read key')">
                            <x-input autocomplete="off" wire:model.debounce="settings.read_key"
                                     :placeholder="__('Invoice/read key')"/>
                        </x-input.group>

                        <x-input.group :for="md5('save')" label="">
                            <x-button primary wire:click="save">
                                <i class="fa fa-solid fa-save"></i>
                                {{ __('Save') }}
                            </x-button>
                        </x-input.group>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
