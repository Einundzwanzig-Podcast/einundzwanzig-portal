<div>
    <div class="border-b border-gray-200 pb-5 sm:pb-0 my-6">
        <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Search') }}</h3>
        <div class="mt-3 sm:mt-4">
            <!-- Tabs at small breakpoint and up -->
            <div class="hidden sm:block">
                <nav class="-mb-px flex space-x-8">
                    @php
                        $currentTab = 'border-amber-500 text-amber-600';
                        $notCurrentTab = 'border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300';
                    @endphp
                    <a href="{{ route('school.table.city', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('school.table.city') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ __('Cities') }}</a>

                    <a href="{{ route('school.table.lecturer', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('school.table.lecturer') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ __('Lecturers') }}</a>

                    <a href="{{ route('school.table.venue', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('school.table.venue') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ __('Venues') }}</a>

                    <a href="{{ route('school.table.course', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('school.table.course') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ __('Courses') }}</a>

                    <a href="{{ route('school.table.event', ['country' => $country]).'#table' }}"
                       class="{{ request()->routeIs('school.table.event') ? $currentTab : $notCurrentTab }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ __('Dates') }}</a>

                </nav>
            </div>
        </div>
    </div>
</div>
