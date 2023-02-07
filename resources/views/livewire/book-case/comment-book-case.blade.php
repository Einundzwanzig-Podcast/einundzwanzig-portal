<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">

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

                            <p class="text-sm font-medium text-gray-900">Neues Foto hochladen</p>

                            <form wire:submit.prevent="save">
                                <div class="text-sm text-gray-500">
                                    <input type="file" wire:model="photo">
                                    @error('photo') <span class="error">{{ $message }}</span> @enderror
                                    <x-button xs secondary type="submit">Hochladen</x-button>
                                </div>
                            </form>

                            @if($bookCase->getMedia('images')->count() > 0)
                                <div
                                    x-data="{
                                    skip: 3,
                                    atBeginning: false,
                                    atEnd: false,
                                    next() {
                                        this.to((current, offset) => current + (offset * this.skip))
                                    },
                                    prev() {
                                        this.to((current, offset) => current - (offset * this.skip))
                                    },
                                    to(strategy) {
                                        let slider = this.$refs.slider
                                        let current = slider.scrollLeft
                                        let offset = slider.firstElementChild.getBoundingClientRect().width
                                        slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
                                    },
                                    focusableWhenVisible: {
                                        'x-intersect:enter'() {
                                            this.$el.removeAttribute('tabindex')
                                        },
                                        'x-intersect:leave'() {
                                            this.$el.setAttribute('tabindex', '-1')
                                        },
                                    },
                                    disableNextAndPreviousButtons: {
                                        'x-intersect:enter.threshold.05'() {
                                            let slideEls = this.$el.parentElement.children

                                            // If this is the first slide.
                                            if (slideEls[0] === this.$el) {
                                                this.atBeginning = true
                                            // If this is the last slide.
                                            } else if (slideEls[slideEls.length-1] === this.$el) {
                                                this.atEnd = true
                                            }
                                        },
                                        'x-intersect:leave.threshold.05'() {
                                            let slideEls = this.$el.parentElement.children

                                            // If this is the first slide.
                                            if (slideEls[0] === this.$el) {
                                                this.atBeginning = false
                                            // If this is the last slide.
                                            } else if (slideEls[slideEls.length-1] === this.$el) {
                                                this.atEnd = false
                                            }
                                        },
                                    },
                                }"
                                    class="flex w-full flex-col"
                                >
                                    <div
                                        x-on:keydown.right="next"
                                        x-on:keydown.left="prev"
                                        tabindex="0"
                                        role="region"
                                        aria-labelledby="carousel-label"
                                        class="flex space-x-6"
                                    >
                                        <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

                                        <!-- Prev Button -->
                                        <button
                                            x-on:click="prev"
                                            class="text-6xl"
                                            :aria-disabled="atBeginning"
                                            :tabindex="atEnd ? -1 : 0"
                                            :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"
                                        >
                                        <span aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path
                                                    stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                        </span>
                                            <span class="sr-only">Skip to previous slide page</span>
                                        </button>

                                        <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

                                        <ul
                                            x-ref="slider"
                                            tabindex="0"
                                            role="listbox"
                                            aria-labelledby="carousel-content-label"
                                            class="flex w-full snap-x snap-mandatory overflow-x-scroll"
                                        >

                                            @foreach($bookCase->getMedia('images') as $image)
                                                <li x-bind="disableNextAndPreviousButtons"
                                                    class="flex w-1/3 shrink-0 snap-start flex-col items-center justify-center p-2"
                                                    role="option">
                                                    <a href="{{ $image->getUrl() }}" target="_blank">
                                                        <img class="mt-2 w-full" src="{{ $image->getUrl('preview') }}"
                                                             alt="placeholder image">
                                                    </a>

                                                    <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">
                                                        #{{ $loop->iteration }} Bild
                                                    </button>

                                                    @if(auth()->user()?->hasRole('super-admin') || app()->environment('local'))
                                                        <x-button wire:click="deletePhoto({{ $image->id }})" xs
                                                                  x-bind="focusableWhenVisible"
                                                                  class="px-4 py-2 text-sm">
                                                            Löschen
                                                        </x-button>
                                                    @endif
                                                </li>
                                            @endforeach

                                        </ul>

                                        <!-- Next Button -->
                                        <button
                                            x-on:click="next"
                                            class="text-6xl"
                                            :aria-disabled="atEnd"
                                            :tabindex="atEnd ? -1 : 0"
                                            :class="{ 'opacity-50 cursor-not-allowed': atEnd }"
                                        >
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                     stroke-width="3"><path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 5l7 7-7 7"/></svg>
                                            </span>
                                            <span class="sr-only">Skip to next slide page</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
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
