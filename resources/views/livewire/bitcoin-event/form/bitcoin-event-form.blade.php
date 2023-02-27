<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Bitcoin Event') }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                @can('delete', $bitcoinEvent)
                    @if($bitcoinEvent->id)
                        <div x-data>
                            <x-button
                                x-on:click="$wireui.confirmDialog({
                                    icon: 'warning',
                                    title: '{{ __('Are you sure you want to delete this Bitcoin event?') }}',
                                    accept: {label: '{{ __('Yes') }}',
                                    execute: () => $wire.deleteMe()},
                                    reject: {label: '{{ __('No, cancel') }}'},
                                })"
                                negative>
                                <i class="fa fa-thin fa-trash"></i>
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    @endif
                @endcan
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

                    <x-input.group :for="md5('image')" :label="__('Logo')">
                        <div class="py-4">
                            @if ($image)
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($bitcoinEvent->getFirstMediaUrl('logo'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $bitcoinEvent->getFirstMediaUrl('logo') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('venue_id')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('Venue') }}
                                </div>
                                <x-button xs href="{{ route('venue.form') }}">
                                    <i class="fa fa-thin fa-plus"></i>
                                    {{ __('Create venue') }}
                                </x-button>
                            </div>
                        </x-slot>
                        <x-select
                            autocomplete="off"
                            wire:model.debounce="bitcoinEvent.venue_id"
                            :placeholder="__('Venue')"
                            :async-data="[
                            'api' => route('api.venues.index'),
                            'method' => 'GET', // default is GET
                        ]"
                            :template="[
                            'name'   => 'user-option',
                            'config' => ['src' => 'flag']
                        ]"
                            option-label="name"
                            option-value="id"
                            option-description="city.name"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.from')" :label="__('Start')">
                        <x-datetime-picker
                            :clearable="false"
                            time-format="24"
                            timezone="UTC"
                            user-timezone="{{ config('app.user-timezone') }}"
                            autocomplete="off"
                            wire:model.debounce="bitcoinEvent.from"
                            display-format="DD-MM-YYYY HH:mm"
                            :placeholder="__('Start')"/>
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.to')" :label="__('To')">
                        <x-datetime-picker
                            :clearable="false"
                            time-format="24"
                            timezone="UTC"
                            user-timezone="{{ config('app.user-timezone') }}"
                            autocomplete="off"
                            wire:model.debounce="bitcoinEvent.to"
                            display-format="DD-MM-YYYY HH:mm"
                            :placeholder="__('To')"/>
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.title')" :label="__('Title')">
                        <x-input autocomplete="off" wire:model.debounce="bitcoinEvent.title"
                                 :placeholder="__('Title')"/>
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.description')" :label="__('Description')">
                        <div
                            class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                        <x-input.simple-mde wire:model.defer="bitcoinEvent.description"/>
                        @error('bitcoinEvent.description') <span
                            class="text-red-500 py-2">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.link')" :label="__('Link')">
                        <x-input autocomplete="off" wire:model.debounce="bitcoinEvent.link"
                                 :placeholder="__('Link')"/>
                    </x-input.group>

                    <x-input.group :for="md5('bitcoinEvent.show_worldwide')" :label="__('Show worldwide')">
                        <x-toggle lg autocomplete="off" wire:model.debounce="bitcoinEvent.show_worldwide"
                                  :placeholder="__('Show worldwide')"/>
                        <p class="text-xs py-2 text-gray-200">{{ __('If checked, the event will be shown everywhere.') }}</p>
                    </x-input.group>

                    <x-input.group :for="md5('action')" :label="__('Action')">
                        <x-button primary wire:click="submit">
                            <i class="fa fa-thin fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
