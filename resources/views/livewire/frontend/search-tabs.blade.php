<div>
    <div class="border-b border-gray-200 pb-5 sm:pb-0 my-6">
        <h3 class="text-lg font-medium leading-6 text-gray-200">Suche</h3>
        <div class="mt-3 sm:mt-4">
            <!-- Tabs at small breakpoint and up -->
            <div class="hidden sm:block">
                <nav class="-mb-px flex space-x-8">
                    @php
                        $currentTab = 'border-amber-500 text-amber-600';
                        $notCurrentTab = 'border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300';
                    @endphp
                    <a href="{{ route('search.city', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('search.city') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Städte</a>

                    <a href="{{ route('search.lecturer', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('search.lecturer') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Dozenten</a>

                    <a href="{{ route('search.venue', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('search.venue') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Veranstaltungs-Orte</a>

                    <a href="{{ route('search.course', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('search.course') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Kurse</a>

                    <a href="{{ route('search.event', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('search.event') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Termine</a>

                </nav>
            </div>
        </div>
    </div>
</div>
