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

                <livewire:tables.library-item-table :currentTab="$currentTab"/>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
