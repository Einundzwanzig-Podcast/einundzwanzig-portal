<div x-data="{ open: false }" class="-mx-3">
    <button type="button"
            class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
            aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
            x-bind:aria-expanded="open.toString()">
        {{ __('Bookcases') }}
        <svg class="h-5 w-5 flex-none"
             x-description="Expand/collapse icon, toggle classes based on menu open state."
             x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd"></path>
        </svg>
    </button>
    <div class="mt-2 space-y-2"
         x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
         x-show="open" style="display: none;" x-cloak>
        <a href="{{ route('bookCases.table.city', ['country' => $country]) }}"
           class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('City search') }}</a>
        <a href="{{ route('bookCases.table.bookcases', ['country' => $country]) }}"
           class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Bookcases') }}</a>
        <a href="{{ route('bookCases.world', ['country' => $country]) }}"
           class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('World map') }}</a>
        @auth
            <a href="{{ route('bookCases.highScoreTable', ['country' => $country]) }}"
               class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Highscore Table') }}</a>
        @endauth
        <a href="https://openbookcase.de/" target="_blank"
           class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Submit new book case') }}</a>
    </div>
</div>
