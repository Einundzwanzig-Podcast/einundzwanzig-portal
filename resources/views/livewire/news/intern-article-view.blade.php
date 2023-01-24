<div class="bg-21gray flex flex-col h-screen justify-between">
    <div class="bg-21gray">
        <div class="mx-auto max-w-screen-2xl py-4 px-6 lg:px-8 overflow-hidden">
            <div class="flex items-center justify-end">
                @if($libraryItem->type === 'markdown_article')
                    <x-button lg :href="route('article.overview')">
                        <i class="fa-thin fa-arrow-left"></i>
                        {{ __('Back to overview') }}
                    </x-button>
                @else
                    <x-button lg :href="route('library.table.libraryItems', ['country' => 'de'])">
                        <i class="fa-thin fa-arrow-left"></i>
                        {{ __('Back to overview') }}
                    </x-button>
                @endif
            </div>
        </div>

        <div class="relative mx-auto max-w-screen-2xl py-4 px-6 lg:px-8 overflow-hidden">
            <div class="absolute top-0 bottom-0 left-3/4 hidden w-screen bg-21gray lg:block"></div>
            <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
                <div>
                    <h2 class="text-lg font-semibold text-amber-600">{{ $libraryItem->tags->pluck('name')->join(', ') }}</h2>
                    <h3 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-100 sm:text-4xl">{{ $libraryItem->name }}</h3>
                </div>
            </div>
            <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
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
            <div class="mt-8 lg:grid lg:grid-cols-2 lg:gap-8">
                <div class="relative lg:col-start-2 lg:row-start-1">
                    <svg class="absolute top-0 right-0 -mt-20 -mr-20 hidden lg:block" width="404" height="384"
                         fill="none" viewBox="0 0 404 384" aria-hidden="true">
                        <defs>
                            <pattern id="de316486-4a29-4312-bdfc-fbce2132a2c1" x="0" y="0" width="20" height="20"
                                     patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#de316486-4a29-4312-bdfc-fbce2132a2c1)"/>
                    </svg>
                    <div class="relative mx-auto max-w-prose text-base lg:max-w-none">
                        <figure>
                            <div class="aspect-w-12 aspect-h-7 lg:aspect-none">
                                <img class="rounded-lg object-cover object-center shadow-lg"
                                     src="{{ $libraryItem->getFirstMediaUrl('main') }}" alt="{{ $libraryItem->name }}"
                                     width="1184" height="1376">
                            </div>
                            <figcaption class="mt-3 flex text-sm text-gray-200">
                                <!-- Heroicon name: mini/camera -->
                                <svg class="h-5 w-5 flex-none text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM10 14a3 3 0 100-6 3 3 0 000 6z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-2">{{ $libraryItem->main_image_caption ?? $libraryItem->name }}</span>
                            </figcaption>
                        </figure>
                        <div class="hidden md:block my-4">
                            @if(auth()->check())
                                <livewire:comments :model="$libraryItem" newest-first/>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-8 lg:mt-0">
                    <div class="mx-auto max-w-prose text-base lg:max-w-none">
                        <p class="text-lg text-gray-200">{{ strip_tags($libraryItem->subtitle) }}</p>
                    </div>
                    <div
                        class="prose md:prose-xl prose-invert mx-auto mt-5 text-gray-100 lg:col-start-1 lg:row-start-1 lg:max-w-none">
                        <div class="flex flex-col space-y-1">
                            @if($libraryItem->type !== 'markdown_article' && str($libraryItem->value)->contains('http'))
                                @if($libraryItem->type === 'youtube_video')
                                    <x-button lg amber :href="$libraryItem->value" target="_blank">
                                        <i class="fa fa-brand fa-youtube mr-2"></i>
                                        {{ __('Open on Youtube') }}
                                    </x-button>
                                @else
                                    <x-button lg amber :href="$libraryItem->value" target="_blank">
                                        <i class="fa fa-thin fa-book-open mr-2"></i>
                                        {{ __('Open') }}
                                    </x-button>
                                @endif
                            @endif
                            @if($libraryItem->type === 'downloadable_file')
                                <x-button lg amber :href="$libraryItem->getFirstMediaUrl('single_file')"
                                          target="_blank">
                                    <i class="fa fa-thin fa-download mr-2"></i>
                                    {{ __('Download') }}
                                </x-button>
                            @endif
                            @if($libraryItem->type === 'podcast_episode')
                                <x-button lg amber :href="$libraryItem->episode->data['link']" target="_blank">
                                    <i class="fa fa-thin fa-headphones mr-2"></i>
                                    {{ __('Listen') }}
                                </x-button>
                            @endif
                            @if($libraryItem->type !== 'markdown_article')
                                <x-button
                                    x-data="{
                                        textToCopy: '{{ url()->route('article.view', ['libraryItem' => $libraryItem]) }}',
                                    }"
                                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                    lg black>
                                    <i class="fa fa-thin fa-copy mr-2"></i>
                                    {{ __('Share link') }}
                                </x-button>
                            @else
                                <x-button
                                    x-data="{
                                        textToCopy: '{{ url()->route('article.view', ['libraryItem' => $libraryItem]) }}',
                                    }"
                                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                    xs black>
                                    <i class="fa fa-thin fa-copy mr-2"></i>
                                    {{ __('Share link') }}
                                </x-button>
                            @endif
                        </div>

                        @if($libraryItem->type === 'youtube_video')
                            <div class="my-12">
                                <x-embed :url="$libraryItem->value"/>
                            </div>
                        @endif

                        @if($libraryItem->type === 'markdown_article')
                            <x-markdown class="leading-normal">
                                {!! $libraryItem->value !!}
                            </x-markdown>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
