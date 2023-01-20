<div class="bg-21gray flex flex-col h-screen justify-between">
    <div class="relative bg-21gray px-6 pt-16 pb-20 lg:px-8 lg:pt-24 lg:pb-28">
        <div class="absolute inset-0">
            <div class="h-1/3 bg-21gray sm:h-2/3"></div>
        </div>
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-200 sm:text-4xl">{{ __('Dezentral News') }}</h2>
                <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">{{ '' }}</p>
            </div>
            <div class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">

                @foreach($libraryItems as $libraryItem)
                    <div wire:key="library_item_{{ $libraryItem->id }}"
                         class="flex flex-col overflow-hidden rounded-lg shadow-[#F7931A] shadow-sm">
                        <div class="flex-shrink-0">
                            <a href="{{ route('article.view', ['libraryItem' => $libraryItem]) }}">
                                <img class="h-48 w-full object-contain"
                                     src="{{ $libraryItem->getFirstMediaUrl('main') }}"
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
                                    <p class="mt-3 text-base text-gray-300 line-clamp-3">{{ $libraryItem->excerpt }}</p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <div>
                                        <span class="sr-only text-gray-200">{{ $libraryItem->lecturer->name }}</span>
                                        <img class="h-10 w-10 rounded"
                                             src="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                             alt="{{ $libraryItem->lecturer->name }}">
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-200">
                                    <div class="text-gray-200">{{ $libraryItem->lecturer->name }}</div>
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500">
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
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
