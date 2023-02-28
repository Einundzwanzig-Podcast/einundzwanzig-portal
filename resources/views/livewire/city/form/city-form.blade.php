<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>
    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('City') }}</h3>
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

                    <x-input.group :for="md5('city.country_id')" :label="__('Country')">
                        <x-select
                            :clearable="false"
                            wire:model="city.country_id"
                            :searchable="true"
                            :async-data="[
                            'api' => route('api.countries.index'),
                            'method' => 'GET', // default is GET
                        ]"
                            :template="[
                            'name'   => 'user-option',
                            'config' => ['src' => 'flag']
                        ]"
                            option-label="name"
                            option-value="id"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('city.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="city.name"
                                 :placeholder="__('Name')"/>
                    </x-input.group>

                    <x-input.group :for="md5('city.latitude')" :label="__('Latitude')">
                        <x-input autocomplete="off" wire:model.debounce="city.latitude"
                                 :placeholder="__('Latitude')"/>
                        <div class="text-amber-500 text-xs py-2"><a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>
                        </div>
                    </x-input.group>

                    <x-input.group :for="md5('city.longitude')" :label="__('Longitude')">
                        <x-input autocomplete="off" wire:model.debounce="city.longitude"
                                 :placeholder="__('Longitude')"/>
                        <div class="text-amber-500 text-xs py-2"><a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>
                        </div>
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.link')" label="">
                        <x-button primary wire:click="save">
                            <i class="fa fa-thin fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>
</div>
