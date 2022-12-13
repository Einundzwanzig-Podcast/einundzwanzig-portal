<div class="bg-21gray flex flex-col justify-between">
    <section class="relative px-10 pt-16 pb-24 sm:py-16 sm:overflow-hidden">
        <img class="absolute h-43 left-0 z-0 w-3/4 transform -translate-y-1/2 opacity-70 top-1/2"
             src="{{ asset('img/gradient-blob.svg') }}">
        <img class="absolute left-0 z-0 object-cover object-center w-full h-full opacity-50 top-24"
             src="https://cdn.devdojo.com/tails/images/swirl-white.svg">
        <div class="container relative z-10 px-4 mx-auto">
            <div class="w-full mb-8 sm:w-1/2 md:w-3/4 sm:pr-4 md:pr-12 sm:-mb-32 md:-mb-24 lg:-mb-36 xl:-mb-28">
                <h2 class="tracking-widest text-amber-500 uppercase">Einundzwanzig</h2>
                <p class="my-3 text-5xl font-bold tracking-tighter text-amber-500 lg:text-6xl">Bitcoin Portal</p>
                <p class="max-w-sm text-lg text-gray-200">
                    Eine Bitcoin Community für alle.
                </p>
                <div class="max-w-sm text-lg text-gray-200">
                    <x-select
                        label="Land wechseln"
                        placeholder="Land wechseln"
                        wire:model="c"
                        :clearable="false"
                    >
                        @foreach($countries as $country)
                            <x-select.user-option
                                src="{{ asset('vendor/blade-country-flags/4x3-'.$country->code.'.svg') }}"
                                label="{{ $country->name }}" value="{{ $country->code }}"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="grid w-full grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                <div class="row-span-2 col-span-full sm:col-span-1 md:col-start-1 sm:row-start-2 md:row-start-3">
                    <a href="{{ route('meetup.table.meetup', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full opacity-30 bg-gradient-to-b from-transparent to-gray-900"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/meetup_saarland.jpg') }}" alt="">
                        </div>
                        <div class="absolute top-1 right-1 z-10 flex flex-col items-end justify-end w-full px-4 py-4">
                                <img class="rounded" src="{{ asset('vendor/blade-country-flags/4x3-'.$c.'.svg') }}" width="64" height="64"/>
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                            <span
                                class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Plebs together strong</span>
                            <h4 class="text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Meetups
                            </h4>
                        </div>
                    </a>
                </div>
                <div
                    class="row-span-2 col-span-full sm:col-span-1 md:col-start-1 xl:col-start-2 sm:row-start-4 md:row-start-5 xl:row-start-2">
                    <a href="{{ route('school.table.city', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full opacity-30 bg-gradient-to-b from-transparent to-gray-900"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/vhs_kurs.jpg') }}" alt="">
                        </div>
                        <div class="absolute top-1 right-1 z-10 flex flex-col items-end justify-end w-full px-4 py-4">
                            <img class="rounded" src="{{ asset('vendor/blade-country-flags/4x3-'.$c.'.svg') }}" width="64" height="64"/>
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                            <span
                            class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Education</span>
                            <h4 class="text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Kurse
                            </h4>
                        </div>
                    </a>
                </div>
                <div
                    class="row-span-2 col-span-full sm:col-span-1 md:col-start-2 xl:col-start-2 sm:row-start-6 md:row-start-2 xl:row-start-4">
                    <a href="{{ route('library.table.libraryItems', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full opacity-30 bg-gradient-to-b from-transparent to-gray-900"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/Krypto-Fiat-Bros.webp') }}" alt="">
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                            <span
                            class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Content</span>
                            <h4 class="text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Bibliothek
                            </h4>
                        </div>
                    </a>
                </div>
                <div
                    class="row-span-2 col-span-full sm:col-span-1 md:col-start-2 xl:col-start-3 sm:row-start-1 md:row-start-4 xl:row-start-1">
                    <a href="{{ route('bitcoinEvent.table.bitcoinEvent', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full opacity-30 bg-gradient-to-b from-transparent to-gray-900"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/20220915_007_industryday.webp') }}" alt="">
                        </div>
                        <div class="absolute top-1 right-1 z-10 flex flex-col items-end justify-end w-full px-4 py-4">
                            <img class="rounded" src="{{ asset('vendor/blade-country-flags/4x3-'.$c.'.svg') }}" width="64" height="64"/>
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                            <span
                            class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Worldwide</span>
                            <h4 class="text-2xl sm:text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Veranstaltungen
                            </h4>
                        </div>
                    </a>
                </div>
                <div
                    class="row-span-2 col-span-full sm:col-span-1 md:col-start-3 xl:col-start-3 sm:row-start-3 md:row-start-1 xl:row-start-3">
                    <a href="{{ route('bookCases.table.bookcases', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full opacity-30 bg-gradient-to-b from-transparent to-gray-900"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/aprycot-media-bitcoin-21-lektionen-01.webp') }}" alt="">
                        </div>
                        <div class="absolute top-1 right-1 z-10 flex flex-col items-end justify-end w-full px-4 py-4">
                            <img class="rounded" src="{{ asset('vendor/blade-country-flags/4x3-'.$c.'.svg') }}" width="64" height="64"/>
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                            <span
                            class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Reading</span>
                            <h4 class="text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Bücher-Schränke
                            </h4>
                        </div>
                    </a>
                </div>
                {{--<div
                    class="row-span-2 col-span-full sm:col-span-1 md:col-start-3 xl:col-start-4 sm:row-start-5 md:row-start-3 xl:row-start-2">
                    <a href="{{ route('bookCases.table.bookcases', ['country' => $c]) }}"
                       class="relative flex flex-col items-start justify-end w-full h-full overflow-hidden bg-black shadow-lg rounded-xl group"
                       style="aspect-ratio: 1/1;">
                        <div class="absolute inset-0 w-full h-full">
                            <div
                                class="absolute bottom-0 left-0 z-10 w-full h-full bg-gradient-to-b from-transparent to-gray-900 opacity-30"></div>
                            <img
                                class="absolute inset-0 object-cover object-center w-full h-full transition duration-500 lg:opacity-80 group-hover:opacity-100 group-hover:scale-110"
                                src="{{ asset('img/aprycot-media-bitcoin-21-lektionen-01.webp') }}" alt="">
                        </div>
                        <div class="relative z-10 flex flex-col items-start justify-start w-full px-6 py-7">
                        <span
                            class="px-2 py-1 mb-3 text-xs font-semibold tracking-tight text-white uppercase bg-amber-500 rounded-md">Reading</span>
                            <h4 class="text-4xl font-bold tracking-tight text-gray-100 sm:text-3xl md:text-2xl lg:text-3xl">
                                Bücher-Schränke
                            </h4>
                        </div>
                    </a>
                </div>--}}
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <div class="fixed bottom-0 w-full">
        <livewire:frontend.footer/>
    </div>
</div>
