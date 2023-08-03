<div>
    <div
        class="flex overflow-auto relative flex-wrap gap-x-1 gap-y-1 justify-left p-0 mx-auto mt-2 mb-2 w-full font-normal text-white align-baseline border-0 border-solid md:mx-auto md:mb-0 md:max-w-screen-2xl"
    >
        @foreach($languages as $language)
            <div
                class="flex flex-wrap justify-left p-0 m-0 text-center align-baseline border-0 border-solid"
                style="font-size: 128%; background-position: 0px center; list-style: outside;"
            >
                <a
                    href="{{ route(request()->route()->getName(), ['country' => $country, 'filters' => ['language' => [$language]]]) }}"
                >
                    @if(in_array($language, $filters['language'] ?? [], false))
                        <x-badge squared amber>
                            {{ $language }}
                        </x-badge>
                    @else
                        <x-badge squared gray>
                            {{ $language }}
                        </x-badge>
                    @endif
                </a>
            </div>
        @endforeach
    </div>
    <div
        class="flex overflow-auto relative flex-wrap gap-x-1 gap-y-1 justify-left p-0 mx-auto mt-2 mb-2 w-full font-normal text-white align-baseline border-0 border-solid md:mx-auto md:mb-0 md:max-w-screen-2xl"
    >
        @foreach($tags as $tag)
            <div
                class="flex flex-wrap justify-left p-0 m-0 text-center align-baseline border-0 border-solid"
                style="font-size: 128%; background-position: 0px center; list-style: outside;"
            >
                <a
                    href="{{ route(request()->route()->getName(), ['country' => $country, 'filters' => ['tag' => [$tag->id]]]) }}"
                >
                    @if(in_array($tag->id, $filters['tag'] ?? [], false))
                        <x-badge squared amber>
                            <i class="fa fa-solid fa-{{ $tag->icon }}"></i>
                            {{ $tag->name }}
                        </x-badge>
                    @else
                        <x-badge squared gray>
                            <i class="fa fa-solid fa-{{ $tag->icon }}"></i>
                            {{ $tag->name }}
                        </x-badge>
                    @endif
                </a>
            </div>
        @endforeach
    </div>
</div>
