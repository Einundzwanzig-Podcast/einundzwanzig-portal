<div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
     @close-popover-group.window="onClosePopoverGroup">
    <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
            @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
            :aria-expanded="open.toString()">
        {{ __('Library') }}
        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         x-description="'Product' flyout menu, show/hide based on flyout menu state."
         class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
         x-ref="panel" @click.away="open = false" x-cloak>
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
            <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                <div>
                    <h3 class="text-sm font-medium leading-6 text-gray-500">{{ __('Library') }}</h3>
                    <div class="mt-6 flow-root">
                        <div class="-my-2">

                            <a href="{{ route('library.table.libraryItems', ['country' => $country]) }}"
                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                <i class="fa-thin fa-search flex-none text-gray-400"></i>
                                {{ __('Search') }}
                            </a>

                            @auth
                                <a href="{{ route('library.table.lecturer', ['country' => $country]) }}"
                                   class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                    <i class="fa-thin fa-school flex-none text-gray-400"></i>
                                    {{ __('Library for lecturers') }}
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium leading-6 text-gray-500">{{ __('Manage') }}</h3>
                    <div class="mt-6 flow-root">
                        <div class="-my-2">

                            <a href="{{ route('library.libraryItem.form', ['country' => $country]) }}"
                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                {{ __('Submit contents') }}
                            </a>

                            <a href="{{ route('school.table.lecturer', ['country' => $country]) }}"
                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                <i class="fa-thin fa-list flex-none text-gray-400"></i>
                                {{ __('Manage content creators') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                <h3 class="sr-only">Recent posts</h3>

                @foreach($libraryItems as $item)
                    <article
                        class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                        <div class="relative flex-none">
                            <img
                                class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                src="{{ $item->getFirstMediaUrl('main') }}"
                                alt="">
                            <div
                                class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div>
                            <div class="flex items-center gap-x-4">
                                <div
                                    class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">
                                    {{ $item->lecturer->name }}
                                </div>
                            </div>
                            <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                <a href="{{ route('libraryItem.view', ['libraryItem' => $item]) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $item->name }}
                                </a>
                            </h4>
                            <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                {{ $item->excerpt }}
                            </p>
                        </div>
                    </article>
                @endforeach

            </div>
        </div>
    </div>
</div>
