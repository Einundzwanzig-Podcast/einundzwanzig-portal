<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Meetup') }}</h3>
            <div class="flex flex-row space-x-2 items-center">

                <div>
                    <x-button :href="$fromUrl">
                        <i class="fa fa-thin fa-arrow-left"></i>
                        {{ __('Back') }}
                    </x-button>
                </div>
            </div>
        </div>

        <form class="space-y-8 divide-y divide-gray-700 pb-24">
            <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                    <x-input.group :for="md5('image')" :label="__('Main picture')">
                        <div class="py-4">
                            @if ($image && str($image->getMimeType())->contains(['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']))
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($meetup->getFirstMediaUrl('logo'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $meetup->getFirstMediaUrl('logo') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('meetup.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.name"
                                 :placeholder="__('Name')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.community')" :label="__('Community')">
                        <x-select
                            :options="['einundzwanzig', 'bitcoin', 'satoshis_coffeeshop']"
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="meetup.community"
                            :placeholder="__('Community')"
                            :hint="__('This is the community that the meetup belongs to. If a community is not listed, please contact the administrator.')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('city_id')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('City/Area') }}
                                </div>
                                <x-button xs :href="route('city.form')">
                                    <i class="fa fa-thin fa-plus"></i>
                                    {{ __('New City') }}
                                </x-button>
                            </div>
                        </x-slot>
                        <x-select
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="meetup.city_id"
                            :placeholder="__('City/Area')"
                            :async-data="[
                            'api' => route('api.cities.index'),
                            'method' => 'GET', // default is GET
                        ]"
                            option-label="name"
                            option-value="id"
                            option-description="country.name"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.intro')" :label="__('Intro')">
                        <x-textarea autocomplete="off" wire:model.debounce="meetup.intro"
                                    :placeholder="__('Intro')"
                                    :hint="__('This is the introduction text that is shown on the landing page.')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.nostr')" :label="__('Nostr public key')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.nostr"
                                 :placeholder="__('Nostr public key')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.simplex')" :label="__('Simplex')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.simplex"
                                 :placeholder="__('Simplex')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.signal')" :label="__('Signal')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.signal"
                                 :placeholder="__('Signal')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.matrix_group')" :label="__('Matrix Group')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.matrix_group"
                                 :placeholder="__('Matrix Group')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.telegram_link')" :label="__('Telegram-Link')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.telegram_link"
                                 :placeholder="__('Telegram-Link')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.webpage')" :label="__('Website')">
                        <x-input type="url" autocomplete="off" wire:model.debounce="meetup.webpage"
                                 :placeholder="__('Link')"/>
                    </x-input.group>

                    <x-input.group :for="md5('meetup.twitter_username')" :label="__('Twitter Username')">
                        <x-input autocomplete="off" wire:model.debounce="meetup.twitter_username"
                                 :placeholder="__('Twitter Username')"
                                 :hint="__('Without @')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetup.link')" :label="__('Action')">
                        <x-button primary wire:click="submit">
                            <i class="fa fa-thin fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>
</div>
