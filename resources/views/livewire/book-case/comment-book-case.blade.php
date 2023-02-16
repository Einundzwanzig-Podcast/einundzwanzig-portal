<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">

            <div class="flex">
                <div class="flex items-center space-x-1"
                     x-data="{currentUrl: window.location.href}">
                    <a
                        x-bind:href="'/{{ $country->code }}/book-cases/book-case/form/{{ $bookCase->id }}/?fromUrl='+currentUrl">
                        <x-button
                            class="whitespace-nowrap" primary class="text-21gray whitespace-nowrap"
                        >
                            {{ __('💊 Orange Pill Now') }}
                        </x-button>
                    </a>
                </div>
            </div>

            <div class="p-4" x-data="{currentUrl: window.location.href}">
                <ul role="list"
                    class="mx-auto grid max-w-2xl grid-cols-2 gap-y-16 gap-x-8 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6">

                    @foreach($bookCase->orangePills as $orangePill)
                        @if($orangePill->user_id === auth()->id())
                            <a x-bind:href="'/{{ $country->code }}/book-cases/book-case/form/{{ $bookCase->id }}/{{ $orangePill->id }}?fromUrl='+currentUrl"
                               wire:key="orange_pill_{{ $loop->index }}">
                                <li class="border border-amber-500 rounded">
                                    <img class="mx-auto h-24 w-24 object-cover rounded"
                                         src="{{ $orangePill->getFirstMediaUrl('images') }}" alt="image">
                                    <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-200">{{ $orangePill->user->name }}</h3>
                                    <p class="text-sm leading-6 text-gray-300">{{ $orangePill->comment }}</p>
                                </li>
                            </a>
                        @else
                            <li>
                                <img class="mx-auto h-24 w-24 object-cover rounded"
                                     src="{{ $orangePill->getFirstMediaUrl('images') }}" alt="">
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-200">{{ $orangePill->user->name }}</h3>
                                <p class="text-sm leading-6 text-gray-300">{{ $orangePill->comment }}</p>
                                <p class="text-sm leading-6 text-gray-300">{{ $orangePill->date->asDateTime() }}</p>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div
                    class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm">
                    {{--<div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>--}}
                    <div class="min-w-0 flex-1">
                        <div class="focus:outline-none space-y-2">
                            <p class="text-sm font-medium text-gray-900">Name</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->title }}</p>
                            <p class="text-sm font-medium text-gray-900">Link</p>
                            <p class="text-sm text-gray-500">
                                <a target="_blank"
                                   href="{{ $this->url_to_absolute($bookCase->homepage) }}">{{ $this->url_to_absolute($bookCase->homepage) }}</a>
                            </p>
                            <p class="text-sm font-medium text-gray-900">Adresse</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->address }}</p>
                            <p class="text-sm font-medium text-gray-900">Art</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->type }}</p>
                            <p class="text-sm font-medium text-gray-900">Geöffnet</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->open }}</p>
                            <p class="text-sm font-medium text-gray-900">Kontakt</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->contact }}</p>
                            <p class="text-sm font-medium text-gray-900">Information</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->comment }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded" wire:ignore>
                    @map([
                    'lat' => $bookCase->latitude,
                    'lng' => $bookCase->longitude,
                    'zoom' => 24,
                    'markers' => [
                    [
                    'title' => $bookCase->title,
                    'lat' => $bookCase->latitude,
                    'lng' => $bookCase->longitude,
                    'url' => 'https://gonoware.com',
                    'icon' => asset('img/btc-logo-6219386_1280.png'),
                    'icon_size' => [42, 42],
                    ],
                    ],
                    ])
                </div>

            </div>

            <div class="my-4">
                <livewire:comments :model="$bookCase" newest-first hide-notification-options/>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
