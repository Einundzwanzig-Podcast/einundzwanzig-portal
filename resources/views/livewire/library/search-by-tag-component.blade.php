<div
    class="flex overflow-auto relative flex-wrap gap-x-5 gap-y-1 justify-center p-0 mx-auto mt-2 mb-2 w-full font-normal text-white align-baseline border-0 border-solid md:mx-auto md:mb-0 md:max-w-screen-2xl"
>
    @foreach($tags as $tag)
        <div
            class="flex flex-wrap justify-center p-0 m-0 text-center align-baseline border-0 border-solid"
            style="font-size: 128%; background-position: 0px center; list-style: outside;"
        >
            <a
                href="{{ route(request()->route()->getName(), ['country' => $country, 'filters' => ['tag' => [$tag->id]]]) }}"
            >
                @if(in_array($tag->id, $filters['tag'] ?? [], false))
                    <x-badge squared amber>
                        <i class="fa fa-thin fa-{{ $tag->icon }}"></i>
                        {{ $tag->name }}
                        {{ $tag->libraryItems->pluck('lecturer.name')->unique()->count() }}
                        {{ __('Creator') }}
                        <span
                            class="inline-block relative top-px py-0 px-1 m-0 text-xs leading-4 align-baseline border-0 border-solid"
                        >•</span>
                        {{ $tag->library_items_count }}
                        {{ __('Entries') }}
                    </x-badge>
                @else
                    <x-badge squared gray>
                        <i class="fa fa-thin fa-{{ $tag->icon }}"></i>
                        {{ $tag->name }}
                        {{ $tag->libraryItems->pluck('lecturer.name')->unique()->count() }}
                        {{ __('Creator') }}
                        <span
                            class="inline-block relative top-px py-0 px-1 m-0 text-xs leading-4 align-baseline border-0 border-solid"
                        >•</span>
                        {{ $tag->library_items_count }}
                        {{ __('Entries') }}
                    </x-badge>
                @endif
            </a>
        </div>
    @endforeach
</div>
