<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="null"/>
    {{-- MAIN --}}
    <section class="w-full mb-12 mt-2">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">

            <div class="relative py-4 sm:py-4">
                <div class="lg:mx-auto lg:grid lg:max-w-7xl lg:grid-cols-2 lg:items-start lg:gap-24 lg:px-8">
                    <div class="relative sm:py-4 lg:py-0">
                        <div aria-hidden="true" class="hidden sm:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-screen">
                            <div class="absolute inset-y-0 right-1/2 w-full rounded-r-3xl lg:right-72"></div>
                            <svg class="absolute top-8 left-1/2 -ml-3 lg:-right-8 lg:left-auto lg:top-12" width="404"
                                 height="392" fill="none" viewBox="0 0 404 392">
                                <defs>
                                    <pattern id="02f20b47-fd69-4224-a62a-4c9de5c763f7" x="0" y="0" width="20"
                                             height="20" patternUnits="userSpaceOnUse">
                                        <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                              fill="currentColor"/>
                                    </pattern>
                                </defs>
                                <rect width="404" height="392" fill="url(#02f20b47-fd69-4224-a62a-4c9de5c763f7)"/>
                            </svg>
                        </div>
                        <div class="relative mx-auto max-w-md px-6 sm:max-w-3xl lg:max-w-none lg:px-0 lg:py-12">
                            <!-- Testimonial card-->
                            <div class="relative overflow-hidden rounded-2xl pt-64 pb-10 shadow-xl">
                                <img class="absolute inset-0 h-full w-full object-contain"
                                     src="{{ $meetup->getFirstMediaUrl('logo', 'preview') }}"
                                     alt="">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-amber-600 via-amber-600 opacity-80"></div>
                                <div class="relative px-8">
                                    <blockquote class="mt-8">
                                        <div class="relative text-lg font-medium text-gray-900 md:flex-grow">
                                            <p class="relative">{{ $meetup->intro }}</p>
                                        </div>

                                        <footer class="mt-4">
                                            <p class="text-base font-semibold text-gray-900">{{ $meetup->users->count() }} {{ __('Plebs') }}</p>
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if(auth()->check())
                                <livewire:comments :model="$meetupEvent" newest-first hide-notification-options/>
                            @endif
                        </div>
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
                                        <x-button
                                            lg primary wire:click="attend">
                                            <i class="fa fa-thin fa-check mr-2"></i>
                                            {{ __('I will show up') }}
                                        </x-button>
                                    @else
                                        <x-button
                                            lg primary wire:click="cannotCome">
                                            <i class="fa fa-thin fa-face-frown mr-2"></i>
                                            {{ __('Unfortunately I cannot come') }}
                                        </x-button>
                                    @endif
                                </div>
                                <div>
                                    @if(!$perhapsShowUp && !$willShowUp)
                                        <x-button
                                            lg wire:click="mightAttend">
                                            <i class="fa fa-thin fa-question mr-2"></i>
                                            {{ __('Might attend') }}
                                        </x-button>
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
                                                <h3 class="text-sm font-medium text-red-800">There were 2 errors with
                                                    your submission</h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul role="list" class="list-disc space-y-1 pl-5">
                                                        <li>Your password must be at least 8 characters</li>
                                                        <li>Your password must include at least one pro wrestling
                                                            finishing move
                                                        </li>
                                                    </ul>
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
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
