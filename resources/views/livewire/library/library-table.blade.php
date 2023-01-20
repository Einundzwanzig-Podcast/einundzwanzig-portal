<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10" id="table">

            <div class="relative border-b border-gray-200 pb-5 sm:pb-0">
                <div class="md:flex md:items-center md:justify-between">
                    @if(request()->route()->getName() === 'library.table.lecturer')
                        <h3 class="text-2xl font-medium leading-6 text-gray-200">{{ __('Lecturer Libraries') }}</h3>
                    @else
                        <h3 class="text-2xl font-medium leading-6 text-gray-200">{{ __('Libraries') }}</h3>
                    @endif
                </div>
                <div class="mt-4">
                    <!-- Dropdown menu on small screens -->
                    {{--<div class="sm:hidden">
                        <label for="current-tab" class="sr-only">Select a tab</label>
                        <select id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-amber-500 focus:outline-none focus:ring-amber-500 sm:text-sm">
                            <option>Applied</option>
                            <option>Phone Screening</option>
                            <option>Interview</option>
                            <option>Offer</option>
                            <option>Hired</option>
                        </select>
                    </div>--}}
                    <!-- Tabs at small breakpoint and up -->
                    <div class="hidden sm:block">
                        <nav class="-mb-px flex space-x-8">
                            @foreach($libraries as $library)
                                @php
                                    $currentLibraryClass = $currentTab === $library['name'] ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
                                @endphp
                                <a href="{{ route(request()->route()->getName(), ['country' => $country, 'currentTab' => $library['name']]) }}"
                                   class="{{ $currentLibraryClass }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ $library['name'] }}</a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>

            <livewire:library.search-by-tag-component/>
            <div class="my-12">

                <div class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">

                    @foreach($libraryItems as $libraryItem)
                        <div wire:key="library_item_{{ $libraryItem->id }}"
                             class="flex flex-col overflow-hidden rounded-lg shadow-[#F7931A] shadow-sm">
                            <div class="flex-shrink-0">
                                <a href="{{ route('article.view', ['libraryItem' => $libraryItem]) }}">
                                    <img class="h-48 w-full object-cover"
                                         src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80"
                                         alt="{{ $libraryItem->name }}">
                                </a>
                            </div>
                            <div class="flex flex-1 flex-col justify-between bg-21gray p-6">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-amber-600">
                                    <div
                                        class="text-amber-500">{{ $libraryItem->tags->pluck('name')->join(', ') }}</div>
                                    </p>
                                    <a href="{{ route('article.view', ['libraryItem' => $libraryItem]) }}"
                                       class="mt-2 block">
                                        <p class="text-xl font-semibold text-gray-200">{{ $libraryItem->name }}</p>
                                        <p class="mt-3 text-base text-gray-300">{{ $libraryItem->excerpt }}</p>
                                    </a>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div>
                                            <span class="sr-only text-gray-200">{{ $libraryItem->lecturer->name }}</span>
                                            <img class="h-10 w-10 rounded-full"
                                                 src="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                                 alt="{{ $libraryItem->lecturer->name }}">
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-200">
                                        <div class="text-gray-200">{{ $libraryItem->lecturer->name }}</div>
                                        </p>
                                        <div class="flex space-x-1 text-sm text-gray-400">
                                            <time datetime="2020-03-16">{{ $libraryItem->created_at->asDateTime() }}</time>
                                            @if($libraryItem->read_time)
                                                <span aria-hidden="true">&middot;</span>
                                                <span>{{ $libraryItem->read_time }} {{ __('min read') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
