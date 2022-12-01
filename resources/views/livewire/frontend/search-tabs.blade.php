<div>
    <div class="border-b border-gray-200 pb-5 sm:pb-0 my-6">
        <h3 class="text-lg font-medium leading-6 text-gray-200">Suche</h3>
        <div class="mt-3 sm:mt-4">
            <!-- Dropdown menu on small screens -->
            <div class="sm:hidden">
                <label for="current-tab" class="sr-only">Select a tab</label>
                <select id="current-tab" name="current-tab"
                        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    <option {{ route('search.city', ['country' => 'de']) ? 'selected' : '' }}>Städte</option>
                    <option {{ route('search.lecturer', ['country' => 'de']) ? 'selected' : '' }}>Dozenten</option>
                    <option {{ route('search.venue', ['country' => 'de']) ? 'selected' : '' }}>Veranstalungs-Orte
                    </option>
                    <option {{ route('search.course', ['country' => 'de']) ? 'selected' : '' }}>Kurse</option>
                </select>
            </div>
            <!-- Tabs at small breakpoint and up -->
            <div class="hidden sm:block">
                <nav class="-mb-px flex space-x-8">
                    @php
                        $currentTab = 'border-amber-500 text-amber-600';
                        $notCurrentTab = 'border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300';
                    @endphp
                    <a href="{{ route('search.city', ['country' => 'de']) }}"
                       class="{{ request()->routeIs('search.city') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Städte</a>

                    <a href="{{ route('search.lecturer', ['country' => 'de']) }}"
                       class="{{ request()->routeIs('search.lecturer') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Dozenten</a>

                    <a href="{{ route('search.venue', ['country' => 'de']) }}"
                       class="{{ request()->routeIs('search.venue') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Veranstaltungs-Orte</a>

                    <a href="{{ route('search.course', ['country' => 'de']) }}"
                       class="{{ request()->routeIs('search.course') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Kurse</a>

                    <a href="{{ route('search.event', ['country' => 'de']) }}"
                       class="{{ request()->routeIs('search.event') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Termine</a>

                </nav>
            </div>
        </div>
    </div>
</div>
