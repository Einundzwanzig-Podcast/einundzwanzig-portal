<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Lecturer/Content Creator') }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                <div>
                    <x-button :href="$fromUrl">
                        <i class="fa fa-solid fa-arrow-left"></i>
                        {{ __('Back') }}
                    </x-button>
                </div>
            </div>
        </div>

        <form class="space-y-8 divide-y divide-gray-700 pb-24">
            <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                    <x-input.group :for=" md5('image')" :label="__('Avatar/Picture')">
                        <div class="py-4">
                            @if ($image && str($image->getMimeType())->contains(['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']))
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($lecturer->getFirstMediaUrl('avatar'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $lecturer->getFirstMediaUrl('avatar') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.name"
                                 :placeholder="__('Name')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.subtitle')" :label="__('Subtitle')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.subtitle"
                                 :placeholder="__('Subtitle')" :hint="__('This is the subtitle on the landing page.')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.intro')" :label="__('Intro')">
                        <div
                            class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                        <x-input.simple-mde wire:model.defer="lecturer.intro"/>
                        @error('lecturer.intro') <span class="text-red-500 py-2">{{ $message }}</span> @enderror
                        <span
                            class="text-gray-400 text-xs py-2">{{ __('This is the introduction text that is shown on the landing page.') }}</span>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.nostr')" :label="__('Nostr public key')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.nostr"
                                 :placeholder="__('Nostr public key')" :hint="__('starts with npub...')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.twitter_username')" :label="__('Twitter Username')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.twitter_username"
                                 :placeholder="__('Twitter Username')" :hint="__('Without @')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.website')" :label="__('Website')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.website"
                                 :placeholder="__('Website')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.paynym')" :label="__('PayNym')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.paynym"
                                 :placeholder="__('PayNym')" :hint="__('starts with PM...')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.lightning_address')" :label="__('Lightning Address')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.lightning_address"
                                 :placeholder="__('Lightning Address')" :hint="__('for example xy@getalby.com')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.lnurl')" :label="__('LNURL')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.lnurl"
                                 :placeholder="__('LNURL')" :hint="__('starts with: lnurl1dp68gurn8gh....')"/>
                    </x-input.group>

                    <x-input.group :for="md5('lecturer.node_id')" :label="__('Node Id')">
                        <x-input autocomplete="off" wire:model.debounce="lecturer.node_id"
                                 :placeholder="__('Node Id')"/>
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.link')" label="">
                        <x-button primary wire:click="save">
                            <i class="fa fa-solid fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
