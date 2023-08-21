<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="null"/>
    {{-- MAIN --}}
    <section class="w-full mb-12 mt-2">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">

            <div class="relative py-4 sm:py-4">
                <div class="lg:mx-auto lg:grid lg:max-w-7xl lg:grid-cols-2 lg:items-start lg:gap-24 lg:px-8">
                    <div class="relative sm:py-4 lg:py-0">
                        <div class="relative mx-auto max-w-md px-6 sm:max-w-3xl lg:max-w-none lg:px-0 lg:py-12">
                            <!-- Testimonial card-->
                            <div class="relative overflow-hidden rounded-2xl pt-64 pb-10l">
                                <img class="absolute inset-0 h-full w-full object-contain"
                                     src="{{ $meetup->getFirstMediaUrl('logo', 'preview') }}"
                                     alt="">
                            </div>
                        </div>
                        <blockquote class="mt-8">
                            <div class="relative text-lg font-medium text-gray-200 md:flex-grow">
                                <p class="relative">{{ $meetup->intro }}</p>
                            </div>
                        </blockquote>

                        <x-button black target="_blank" class="my-6"
                                  :href="route('export.meetupEvent', ['meetupEvent' => $meetupEvent])">
                            <i class="fa-thin fa-file-excel"></i>
                            {{ __('Download') }}
                        </x-button>

                        <div class="border-b border-gray-200 pb-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-200">{{ __('Confirmations') }}</h3>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">

                            @foreach($attendees as $a)
                                <li class="flex py-4">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $a['user']['profile_photo_url'] ?? 'https://ui-avatars.com/api/?name='.urlencode($a['name']).'&color=7F9CF5&background=EBF4FF' }}"
                                         alt="{{ $a['name'] }}">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-200">{{ $a['name'] }}</p>
                                        <p class="text-sm text-green-300">{{ __('Participation confirmed') }}</p>
                                    </div>
                                </li>
                            @endforeach

                        </ul>

                        <div class="border-b border-gray-200 pb-5 mt-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-200">{{ __('Perhaps') }}</h3>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">

                            @foreach($mightAttendees as $a)
                                <li class="flex py-4">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $a['user']['profile_photo_url'] ?? 'https://ui-avatars.com/api/?name='.urlencode($a['name']).'&color=7F9CF5&background=EBF4FF' }}"
                                         alt="{{ $a['name'] }}">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-200">{{ $a['name'] }}</p>
                                        <p class="text-sm text-yellow-300">{{ __('Perhaps') }}</p>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    <div class="relative mx-auto max-w-md px-6 sm:max-w-3xl lg:px-0">
                        <!-- Content area -->
                        <div class="pt-12 sm:pt-16 lg:pt-20">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-200 sm:text-4xl">{{ $meetup->name }}</h2>
                            <div class="mt-6 space-y-6 text-gray-100">
                                <p class="font-bold text-xl">
                                    {{ __('When') }}: {{ $meetupEvent->start->asDateTime() }}
                                </p>
                                <p class="font-bold text-xl">
                                    {{ __('Where') }}: {{ $meetupEvent->location }}
                                </p>
                                <div class="prose prose-invert leading-normal">
                                    <x-markdown>
                                        {!! $meetupEvent->description !!}
                                    </x-markdown>
                                </div>
                                <div>
                                    @if($meetupEvent->link)
                                        <x-button
                                            target="_blank"
                                            :href="$meetupEvent->link"
                                            primary lg class="mt-4 whitespace-nowrap">
                                            <i class="fa fa-thin fa-external-link mr-2"></i>
                                            {{ __('Event-Link') }}
                                        </x-button>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-6 space-y-6 text-gray-100 flex flex-col space-y-2">
                                <div>
                                    @if($meetup->telegram_link)
                                        <x-button
                                            target="_blank"
                                            :href="$meetup->telegram_link"
                                            secondary lg class="mt-4 whitespace-nowrap">
                                            <i class="fa fa-thin fa-external-link mr-2"></i>
                                            {{ __('Telegram-Link') }}
                                        </x-button>
                                    @endif
                                </div>
                                <div>
                                    @if($meetup->webpage)
                                        <x-button
                                            target="_blank"
                                            :href="$meetup->webpage"
                                            secondary lg class="mt-4 whitespace-nowrap">
                                            <i class="fa fa-thin fa-external-link mr-2"></i>
                                            {{ __('Website') }}
                                        </x-button>
                                    @endif
                                </div>
                                <div>
                                    @if($meetup->matrix_group)
                                        <x-button
                                            target="_blank"
                                            :href="$meetup->matrix_group"
                                            secondary lg class="mt-4 whitespace-nowrap">
                                            <i class="fa fa-thin fa-people-group mr-2"></i>
                                            {{ __('Matrix-Group') }}
                                        </x-button>
                                    @endif
                                </div>
                                <div>
                                    @if($meetup->twitter_username)
                                        <x-button
                                            target="_blank"
                                            :href="'https://twitter.com/'.$meetup->twitter_username"
                                            secondary lg class="mt-4 whitespace-nowrap">
                                            <i class="fa fa-thin fa-external-link mr-2"></i>
                                            {{ __('Twitter') }}
                                        </x-button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Stats section -->
                        <div class="mt-10">
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-8">

                                <div class="border-t-2 border-gray-100 pt-6">
                                    <dt class="text-base font-medium text-gray-200">{{ __('Confirmations') }}</dt>
                                    <dd class="text-3xl font-bold tracking-tight text-gray-300">{{ count($meetupEvent->attendees ?? []) }}</dd>
                                </div>

                                <div class="border-t-2 border-gray-100 pt-6">
                                    <dt class="text-base font-medium text-gray-200">{{ __('Perhaps') }}</dt>
                                    <dd class="text-3xl font-bold tracking-tight text-gray-300">{{ count($meetupEvent->might_attendees ?? []) }}</dd>
                                </div>

                            </dl>

                            <div class="mt-6">
                                <x-input
                                    wire:model.debounce="name"
                                    label="{{ __('Name') }}"
                                    hint="{{ __('Your unique name so that we can count the number of participants correctly (does not necessarily have to be your real name)') }}"
                                />
                            </div>

                            <div class="mt-10 flex flex-row space-x-2 items-center">
                                <div>
                                    @if(!$willShowUp && !$perhapsShowUp)
                                        <div x-data="{}">
                                            <x-button
                                                lg primary
                                                x-on:click="$wireui.confirmDialog({
                                                    id: 'attend-event',
                                                    icon: 'question',
                                                    accept: {label: '{{ __('Yes') }}',
                                                        execute: () => $wire.attend()},
                                                    reject: {label: '{{ __('No, cancel') }}',
                                                        execute: () => window.$wireui.notify({'title': '{{ __('You have not confirmed your participation.') }}','icon': 'warning'})}
                                                })"
                                            >
                                                <i class="fa fa-thin fa-check mr-2"></i>
                                                {{ __('I will show up') }}
                                            </x-button>
                                        </div>
                                    @else
                                        <div x-data="{}">
                                            <x-button
                                                x-on:click="$wireui.confirmDialog({
                                                        icon: 'question',
                                                        title: '{{ __('Are you sure you want to cancel your participation?') }}',
                                                        accept: {label: '{{ __('Yes') }}',
                                                        execute: () => $wire.cannotCome()},
                                                        reject: {label: '{{ __('No, cancel') }}',
                                                }})"
                                                lg primary>
                                                <i class="fa fa-thin fa-face-frown mr-2"></i>
                                                {{ __('Unfortunately I cannot come') }}
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if(!$perhapsShowUp && !$willShowUp)
                                        <div x-data="{}">
                                            <x-button
                                                x-on:click="$wireui.confirmDialog({
                                                    id: 'attend-event',
                                                    icon: 'question',
                                                    accept: {label: '{{ __('Yes') }}',
                                                    execute: () => $wire.mightAttend()},
                                                    reject: {label: '{{ __('No, cancel') }}',
                                                    execute: () => window.$wireui.notify({'title': '{{ __('You have not confirmed your participation.') }}','icon': 'warning'})}})"
                                                lg>
                                                <i class="fa fa-thin fa-question mr-2"></i>
                                                {{ __('Might attend') }}
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-6">
                                @auth
                                @else
                                    <div class="rounded-md bg-red-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: mini/x-circle -->
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">
                                                    {{ __('Remember that you are currently not logged in.') }}
                                                </h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul role="list" class="list-disc space-y-1 pl-5">
                                                        <li>{{ __('Your participation will only be saved for one week in the current browser session.') }}</li>
                                                        <li>{{ __('You cannot withdraw your participation after one week.') }}</li>
                                                        <li>{{ __('Log in so that you can edit your participation at any time.') }}</li>
                                                    </ul>
                                                    <div class="w-full flex justify-end">
                                                        <x-button xs secondary :href="route('auth.login')">
                                                            <i class="fa fa-thin fa-sign-in"></i>
                                                            {{ __('Login') }}
                                                        </x-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    @push('modals')
        <x-dialog id="attend-event" title="{{ __('Confirmation') }}"
                  description="{{ __('You confirm your participation.') }}">
            @auth
            @else
                <div class="rounded-md bg-transparent p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: mini/x-circle -->
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-500">
                                {{ __('Remember that you are currently not logged in.') }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li>{{ __('Your participation will only be saved for one week in the current browser session.') }}</li>
                                    <li>{{ __('You cannot withdraw your participation after one week.') }}</li>
                                    <li>{{ __('Log in so that you can edit your participation at any time.') }}</li>
                                </ul>
                                <div class="w-full flex justify-end">
                                    <x-button xs secondary :href="route('auth.login')">
                                        <i class="fa fa-thin fa-sign-in"></i>
                                        {{ __('Login') }}
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </x-dialog>
    @endpush
    {{-- FOOTER --}}
    <livewire:frontend.footer/>

    <div wire:ignore class="z-50 hidden md:block">
        <script
            src="{{ asset('dist/einundzwanzig.chat.js') }}"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig_portal_{{ str($meetupEvent->meetup->slug)->replace('-', '_') }}"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
    </div>
</div>
