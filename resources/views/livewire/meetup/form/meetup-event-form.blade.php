<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Meetup Event') }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                <div>
                    @if($meetupEvent->id)
                        <x-button negative wire:click="deleteMe">
                            <i class="fa fa-solid fa-trash"></i>
                            {{ __('Delete') }}
                        </x-button>
                    @endif
                </div>
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

                    <x-input.group :for="md5('meetup_id')" :label="__('Meetup')">
                        <x-select
                            autocomplete="off"
                            wire:model.debounce="meetupEvent.meetup_id"
                            :placeholder="__('Meetup')"
                            :async-data="[
                            'api' => route('api.meetup.index'),
                            'method' => 'GET', // default is GET
                            'params' => ['user_id' => auth()->id()], // default is []
                        ]"
                            :template="[
                            'name'   => 'user-option',
                            'config' => ['src' => 'profile_image']
                        ]"
                            option-label="name"
                            option-value="id"
                            option-description="city.name"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.start')" :label="__('Start')">
                        <x-datetime-picker
                            :clearable="false"
                            time-format="24"
                            timezone="UTC"
                            user-timezone="{{ config('app.user-timezone') }}"
                            autocomplete="off"
                            wire:model.debounce="meetupEvent.start"
                            display-format="DD-MM-YYYY HH:mm"
                            :placeholder="__('Start')"/>
                    </x-input.group>

                    @if(!$meetupEvent->id && $meetupEvent->start)
                        <x-input.group :for="md5('recurringid')" :label="__('Recurring appointment / monthly')">
                            <x-toggle lg :label="__('Recurring appointment')" wire:model="recurring"/>
                            <p class="text-xs text-amber-400 py-2">{{ __('The recurring appointments are created in the database as new entries. Please be careful with this function, otherwise you will have to change or delete all the appointments you have created manually if you make an error.') }}</p>
                        </x-input.group>
                    @endif

                    @if($recurring)
                        <x-input.group :for="md5('repetitions')" :label="__('Number of repetitions')">
                            <x-input type="number" autocomplete="off" wire:model.debounce="repetitions"
                                     :placeholder="__('Number of repetitions')"/>
                        </x-input.group>
                    @endif

                    <x-input.group :for="md5('meetupEvent.location')" :label="__('Location')">
                        <x-input autocomplete="off" wire:model.debounce="meetupEvent.location"
                                 :placeholder="__('Location')"/>
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.description')" :label="__('Description')">
                        <x-textarea autocomplete="off" wire:model.debounce="meetupEvent.description"
                                    :placeholder="__('Description')"/>
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.link')" :label="__('Link')">
                        <x-input type="url" autocomplete="off" wire:model.debounce="meetupEvent.link"
                                 :placeholder="__('Link')"
                                 :hint="__('For example, a link to a location on Google Maps or a link to a website. (not your Telegram group link)')"/>
                    </x-input.group>

                    <x-input.group :for="md5('grid')" :label="__('Recurring appointments')">
                        @if($recurring && count($series) === $repetitions)
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                                @for($i = 0; $i < $repetitions; $i++)
                                    <x-datetime-picker
                                        :label="\App\Support\Carbon::parse($series[$i]['start'])->asDayNameAndMonthName()"
                                        :clearable="false"
                                        time-format="24"
                                        timezone="UTC"
                                        user-timezone="{{ config('app.user-timezone') }}"
                                        autocomplete="off"
                                        wire:model.debounce="series.{{ $i }}.start"
                                        display-format="DD-MM-YYYY HH:mm"
                                        :placeholder="__('Start')"/>
                                @endfor
                            </div>
                        @endif
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.link')" :label="__('Action')">
                        <x-button primary wire:click="submit">
                            <i class="fa fa-solid fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>
</div>
