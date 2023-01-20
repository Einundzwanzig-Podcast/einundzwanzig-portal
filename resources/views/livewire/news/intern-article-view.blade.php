<div class="bg-21gray flex flex-col h-screen justify-between">
    <div class="overflow-hidden bg-21gray">
        <div class="relative mx-auto max-w-7xl py-16 px-6 lg:px-8">
            <div class="absolute top-0 bottom-0 left-3/4 hidden w-screen bg-21gray lg:block"></div>
            <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
                <div>
                    <h2 class="text-lg font-semibold text-amber-600">{{ $libraryItem->tags->pluck('name')->join(', ') }}</h2>
                    <h3 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-100 sm:text-4xl">{{ $libraryItem->name }}</h3>
                </div>
            </div>
            <div class="mt-8 lg:grid lg:grid-cols-2 lg:gap-8">
                <div class="relative lg:col-start-2 lg:row-start-1">
                    <svg class="absolute top-0 right-0 -mt-20 -mr-20 hidden lg:block" width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                        <defs>
                            <pattern id="de316486-4a29-4312-bdfc-fbce2132a2c1" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#de316486-4a29-4312-bdfc-fbce2132a2c1)" />
                    </svg>
                    <div class="relative mx-auto max-w-prose text-base lg:max-w-none">
                        <figure>
                            <div class="aspect-w-12 aspect-h-7 lg:aspect-none">
                                <img class="rounded-lg object-cover object-center shadow-lg" src="{{ $libraryItem->getFirstMediaUrl('main') }}" alt="{{ $libraryItem->name }}" width="1184" height="1376">
                            </div>
                            <figcaption class="mt-3 flex text-sm text-gray-200">
                                <!-- Heroicon name: mini/camera -->
                                <svg class="h-5 w-5 flex-none text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM10 14a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2">{{ $libraryItem->main_image_caption ?? $libraryItem->name }}</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="mt-8 lg:mt-0">
                    <div class="mx-auto max-w-prose text-base lg:max-w-none">
                        <p class="text-lg text-gray-200">{{ $libraryItem->subtitle }}</p>
                    </div>
                    <div class="prose prose-invert mx-auto mt-5 text-gray-100 lg:col-start-1 lg:row-start-1 lg:max-w-none">
                        <x-markdown>
                            {!! $libraryItem->value !!}
                        </x-markdown>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
