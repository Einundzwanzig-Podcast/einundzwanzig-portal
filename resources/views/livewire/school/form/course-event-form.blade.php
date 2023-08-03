<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Course Event') }}</h3>
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

                    <x-input.group :for="md5('course_id')" :label="__('Course')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('Course') }}
                                </div>
                                <x-button xs href="{{ route('course.form.course') }}">
                                    <i class="fa fa-solid fa-plus"></i>
                                    {{ __('Register course') }}
                                </x-button>
                            </div>
                        </x-slot>
                        <x-select
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="courseEvent.course_id"
                            :placeholder="__('Course')"
                            :async-data="[
                                'api' => route('api.courses.index'),
                                'method' => 'GET', // default is GET
                                'params' => ['user_id' => auth()->id()], // default is []
                            ]"
                            :template="[
                                'name'   => 'user-option',
                                'config' => ['src' => 'image']
                            ]"
                            option-label="name"
                            option-value="id"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('venue_id')" :label="__('Venue')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('Venue') }}
                                </div>
                                <x-button xs href="{{ route('venue.form') }}">
                                    <i class="fa fa-solid fa-plus"></i>
                                    {{ __('Create venue') }}
                                </x-button>
                            </div>
                        </x-slot>
                        <x-select
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="courseEvent.venue_id"
                            :placeholder="__('Venue')"
                            :async-data="[
                                'api' => route('api.venues.index'),
                                'method' => 'GET', // default is GET
                                'params' => ['user_id' => auth()->id()], // default is []
                            ]"
                            :template="[
                                'name'   => 'user-option',
                                'config' => ['src' => 'flag']
                            ]"
                            option-label="name"
                            option-value="id"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('courseEvent.from')" :label="__('From')">
                        <x-datetime-picker
                            :clearable="false"
                            time-format="24"
                            timezone="UTC"
                            user-timezone="{{ config('app.user-timezone') }}"
                            autocomplete="off"
                            wire:model.debounce="courseEvent.from"
                            display-format="DD-MM-YYYY HH:mm"
                            :placeholder="__('To')"/>
                    </x-input.group>

                    <x-input.group :for="md5('courseEvent.to')" :label="__('To')">
                        <x-datetime-picker
                            :clearable="false"
                            time-format="24"
                            timezone="UTC"
                            user-timezone="{{ config('app.user-timezone') }}"
                            autocomplete="off"
                            wire:model.debounce="courseEvent.to"
                            display-format="DD-MM-YYYY HH:mm"
                            :placeholder="__('To')"/>
                    </x-input.group>

                    <x-input.group :for="md5('courseEvent.link')" :label="__('Link')">
                        <x-input autocomplete="off" wire:model.debounce="courseEvent.link"
                                 :placeholder="__('Link')"/>
                    </x-input.group>

                    <x-input.group :for="md5('save')" label="">
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
