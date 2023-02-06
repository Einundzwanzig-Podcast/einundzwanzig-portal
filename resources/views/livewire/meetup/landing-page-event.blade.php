<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="null"/>
    {{-- MAIN --}}
    <section class="w-full mb-12 mt-2">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">

            <div class="relative py-4 sm:py-4">
                <div class="lg:mx-auto lg:grid lg:max-w-7xl lg:grid-cols-2 lg:items-start lg:gap-24 lg:px-8">
                    <div class="relative sm:py-16 lg:py-0">
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
                        <div class="relative mx-auto max-w-md px-6 sm:max-w-3xl lg:max-w-none lg:px-0 lg:py-20">
                            <!-- Testimonial card-->
                            <div class="relative overflow-hidden rounded-2xl pt-64 pb-10 shadow-xl">
                                <img class="absolute inset-0 h-full w-full object-cover"
                                     src="{{ $meetup->getFirstMediaUrl('logo', 'preview') }}"
                                     alt="">
                                <div class="absolute inset-0 bg-amber-500 mix-blend-multiply"></div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-amber-600 via-amber-600 opacity-90"></div>
                                <div class="relative px-8">
                                    <blockquote class="mt-8">
                                        <div class="relative text-lg font-medium text-white md:flex-grow">
                                            <p class="relative">{{ $meetup->intro }}</p>
                                        </div>

                                        <footer class="mt-4">
                                            <p class="text-base font-semibold text-amber-200">{{ $meetup->users->count() }} {{ __('Plebs') }}</p>
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
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
                                <p>
                                    {{ $meetupEvent->description }}
                                </p>
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
                                            {{ __('Unfortunately I can\'t come') }}
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
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
