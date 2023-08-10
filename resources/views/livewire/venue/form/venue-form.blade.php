<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>
    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Venue') }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                {{--<div>
                    @if($venue->id)
                        <x-button negative wire:click="deleteMe">
                            <i class="fa fa-thin fa-trash"></i>
                            {{ __('Delete') }}
                        </x-button>
                    @endif
                </div>--}}
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

                    <x-input.group :for="md5('image')" :label="__('Images')">
                        <div class="py-4">
                            @if ($images)
                                <div class="grid grid-cols-4 gap-1">
                                    @foreach($images as $image)
                                        @if(str($image->getMimeType())->contains(['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']))
                                            <div>
                                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if ($venue->getMedia('images'))
                                <div class="text-gray-200">{{ __('Current pictures') }}:</div>
                                <div class="grid grid-cols-4 gap-1">
                                    @foreach($venue->getMedia('images') as $image)
                                        <div class="space-y-2" wire:key="image_{{ $image->id }}"
                                             wire:click="deleteMedia({{ $image->id }})">
                                            <div class="flex justify-center">
                                                <img class="h-48 object-contain" src="{{ $image->getUrl() }}">
                                            </div>
                                            <div class="flex justify-center">
                                                <x-button xs>
                                                    <i class="fa-thin fa-trash"></i>
                                                    {{ __('Delete') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" multiple wire:model="images">
                    </x-input.group>

                    <x-input.group :for="md5('city_id')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('City') }}
                                </div>
                                <x-button xs href="{{ route('city.form') }}">
                                    <i class="fa fa-thin fa-plus"></i>
                                    {{ __('New City') }}
                                </x-button>
                            </div>
                        </x-slot>
                        <x-select
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="venue.city_id"
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

                    <x-input.group :for="md5('venue.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="venue.name"
                                 :placeholder="__('Name')"/>
                    </x-input.group>

                    <x-input.group :for="md5('venue.street')" :label="__('Address')">
                        <x-input autocomplete="off" wire:model.debounce="venue.street"
                                 :placeholder="__('Address')"/>
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
</div>
