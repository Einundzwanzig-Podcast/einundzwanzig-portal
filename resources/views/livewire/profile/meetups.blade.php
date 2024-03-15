<div class="bg-21gray h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <section class="">
        <div class="px-10 pt-6 mx-auto max-w-7xl">
            <div class="w-full mx-auto text-left md:text-center">
                <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-900 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                    <span
                        class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-500 lg:inline">{{ __('My meetups') }}</span>
                </h1>
                <p class="px-0 mb-6 text-lg text-gray-200 md:text-xl lg:px-24">
                    {{ __('Select one or more meetup groups so that you can get access to these groups in the backend.') }}
                </p>
            </div>
            <div class="flex flex-col space-y-2">
                @if(auth()->check() && auth()->user()->meetups->count() > 0)
                    <x-button
                        x-data="{
                                    textToCopy: '{{ route('meetup.ics', ['country' => 'de', 'my' => auth()->user()->meetups->pluck('id')->toArray()]) }}',
                                }"
                        @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
                        black>
                        <i class="fa fa-thin fa-calendar-heart mr-2"></i>
                        {{ __('Calendar Stream-Url for my meetups only') }}
                    </x-button>
                @endif
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2">

        <div class="p-4 w-full">
            <p class="px-0 mb-6 text-lg text-gray-200 md:text-xl">
                {{ __('Your current Meetup groups') }}
            </p>
            <div class="grid grid-cols-1 gap-2">
                @foreach($myMeetupNames as $myMeetup)
                    <div class="flex flex-col sm:flex-row items-center space-x-2 space-y-1 sm:space-y-0">
                        <div>
                            <a href="{{ $myMeetup['link'] }}">
                                <x-badge
                                    class="whitespace-nowrap" lg outline white
                                    label="{{ $myMeetup['name'] }}"/>
                            </a>
                        </div>
                        <div class="flex flex-col sm:flex-row space-y-1 sm:space-y-0 sm:space-x-1 justify-center">
                            <x-badge
                                x-data="{}"
                                @click.prevent="window.navigator.clipboard.writeText('{{ $myMeetup['ics'] }}');window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
                                primary lg class="whitespace-nowrap cursor-pointer">
                                <i class="fa fa-thin fa-calendar-circle-exclamation mr-2"></i>
                                {{ __('Calendar') }}
                            </x-badge>
                            <a
                                href="{{ route('meetup.meetup.form', ['meetup' => $myMeetup['id'], 'country' =>  $myMeetup['country']]) }}">
                                <x-badge
                                    primary lg class="whitespace-nowrap cursor-pointer">
                                    <i class="fa fa-thin fa-edit mr-2"></i>
                                    {{ __('Edit') }}
                                </x-badge>
                            </a>
                            <a
                                href="{{ route('meetup.table.meetupEvent', ['country' =>  $myMeetup['country']]) }}">
                                <x-badge
                                    primary lg class="whitespace-nowrap cursor-pointer">
                                    <i class="fa fa-thin fa-list mr-2"></i>
                                    {{ __('Events') }}
                                </x-badge>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="">
            <div class="px-10 pt-6 mx-auto max-w-7xl">
                <div class="bg-21gray p-6 rounded">

                    <div>
                        <x-input wire:model="search" placeholder="{{ __('Search') }}"
                                 hint="{{ __('please limit your search here') }}">
                            <x-slot name="append">
                                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                    <x-button
                                        wire:click="$set('search', '')"
                                        class="h-full rounded-r-md"
                                        black
                                        flat
                                        squared
                                    >
                                        <i class="fa-thin fa-xmark"></i>
                                    </x-button>
                                </div>
                            </x-slot>
                        </x-input>
                    </div>

                    <div class="mt-6 flow-root">

                        <ul role="list" class="-my-5 divide-y divide-gray-200">

                            @foreach($meetups as $meetup)

                                @php
                                    $activeClass = in_array($meetup->id, $myMeetups, true) ? 'font-bold text-amber-500' : 'text-gray-200';
                                @endphp

                                <li class="py-4" wire:key="meetup_id_{{ $meetup->id }}">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-12 w-12 rounded object-cover"
                                                 src="{{ $meetup->getFirstMediaUrl('logo') }}"
                                                 alt="{{ $meetup->name }}">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium {{ $activeClass }}">{{ $meetup->name }}</p>
                                            <p class="truncate text-sm {{ $activeClass }}">{{ $meetup->city->name }}</p>
                                        </div>
                                        <div>
                                            @if(in_array($meetup->id, $myMeetups, true))
                                                <x-button
                                                    primary
                                                    wire:click="signUpForMeetup({{ $meetup->id }})"
                                                >
                                                    <i class="fa-thin fa-xmark"></i>
                                                    {{ __('Deselect') }}
                                                </x-button>
                                            @else
                                                <x-button
                                                    black
                                                    wire:click="signUpForMeetup({{ $meetup->id }})"
                                                >
                                                    <i class="fa-thin fa-check"></i>
                                                    {{ __('Select') }}
                                                </x-button>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
