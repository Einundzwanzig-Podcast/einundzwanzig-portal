<div
    class="flex overflow-auto relative flex-wrap gap-x-5 gap-y-6 justify-center p-0 mx-auto mt-8 mb-3 w-full font-normal leading-6 text-white align-baseline border-0 border-solid md:mx-auto md:mb-0 md:max-w-screen-md"
    style="max-width: 1350px; font-size: 128%; background-position: 0px center; max-height: 500px; list-style: outside;"
>
    @foreach($tags->sortBy('name') as $tag)
        <div
            class="flex flex-1 justify-center p-0 m-0 leading-6 text-center align-baseline border-0 border-solid"
            style="font-size: 128%; background-position: 0px center; list-style: outside;"
        >
            @php
                $isActive = collect($table)->pluck('tag')->collapse()->contains($tag->name);
                $activeClass = $isActive ? 'text-amber-500 bg-amber-500' : 'bg-blue-50 text-white hover:text-amber-500';
            @endphp
            <a
                class="{{ $activeClass }} flex relative flex-col flex-shrink-0 justify-between py-1 px-3 w-full h-20 border-0 border-solid duration-300 ease-in-out cursor-pointer bg-opacity-[0.07]"
                href="{{ route(request()->route()->getName(), ['country' => $country, 'table' => ['filters' => ['tag' => [$tag->id]]]]) }}"
            >
                <div
                    class="flex flex-1 items-center p-0 m-0 text-center align-baseline border-0 border-solid"
                >
                    <div
                        class="flex flex-shrink-0 justify-center p-0 my-0 mr-4 ml-0 align-baseline border-0 border-solid"
                    >
                        <i class="fa fa-thin fa-{{ $tag->icon }} text-4xl"></i>
                    </div>
                    <div
                        class="flex justify-between p-0 m-0 w-full align-baseline border-0 border-solid md:block lg:w-auto"
                    >
                        <h2
                            class="p-0 m-0 font-sans text-base font-semibold tracking-wide leading-tight text-left align-baseline border-0 border-solid"
                            style="background-position: 0px center; list-style: outside;"
                        >
                            {{ $tag->name }}
                        </h2>
                        <div
                            class="hidden p-0 m-0 text-sm leading-3 text-left text-blue-100 align-baseline border-0 border-solid md:block md:text-blue-100 whitespace-nowrap"
                        >
                            {{ $tag->libraryItems->pluck('lecturer.name')->unique()->count() }}
                            {{ __('Creator') }}
                            <span
                                class="inline-block relative top-px py-0 px-1 m-0 text-xs leading-4 align-baseline border-0 border-solid"
                            >
                              •
                            </span>
                            {{ $tag->library_items_count }}
                            {{ __('Contents') }}
                        </div>
                    </div>
                </div>
            </a
            >
        </div>
    @endforeach
</div>
