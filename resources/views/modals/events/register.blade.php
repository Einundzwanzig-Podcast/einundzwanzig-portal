<x-jet-dialog-modal wire:model="viewingModal" maxWidth="screen" bg="bg-21gray">
    <x-slot name="title">
        <div class="text-gray-200">
            {{ __('Registration') }}
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="relative py-16">
            <div class="absolute inset-x-0 top-0 hidden h-1/2 lg:block" aria-hidden="true"></div>
            <div class="mx-auto max-w-7xl bg-indigo-600 lg:bg-transparent lg:px-8">
                <div class="lg:grid lg:grid-cols-12">
                    <div class="relative z-10 lg:col-span-4 lg:col-start-1 lg:row-start-1 lg:bg-transparent lg:py-16">
                        <div class="absolute inset-x-0 h-1/2 lg:hidden" aria-hidden="true"></div>
                        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-none lg:p-0 space-y-2">
                            <div class="aspect-w-10 aspect-h-6 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1">
                                <img class="rounded-3xl object-cover object-center shadow-2xl"
                                     src="{{ $currentModal?->course->getFirstMediaUrl('logo') }}"
                                     alt="{{ $currentModal?->course->name }}">
                            </div>
                            @foreach($currentModal?->course->getMedia('images') ?? [] as $image)
                                <div class="aspect-w-10 aspect-h-6 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1">
                                    <img class="rounded-3xl object-cover object-center shadow-2xl"
                                         src="{{ $image->getUrl() }}"
                                         alt="{{ $currentModal?->course->name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div
                        class="relative bg-amber-600 py-4 lg:col-span-10 lg:col-start-3 lg:row-start-1 lg:grid lg:grid-cols-10 lg:items-center lg:rounded-3xl">
                        <div
                            class="relative mx-auto max-w-md space-y-6 py-12 px-4 sm:max-w-3xl sm:py-16 sm:px-6 lg:col-span-6 lg:col-start-4 lg:max-w-none lg:p-0">
                            <h2 class="text-3xl font-bold tracking-tight text-white"
                                id="join-heading">{{ $currentModal?->course->name }}</h2>
                            <a class="block w-full rounded-md border border-transparent bg-white py-3 px-5 text-center text-base font-medium text-amber-500 shadow-md hover:bg-gray-50 sm:inline-block sm:w-auto"
                               href="{{ $currentModal?->link }}" target="_blank">Link zur Anmeldung</a>
                            <x-markdown>
                                {{ $currentModal?->course->description }}
                            </x-markdown>
                            <a class="block w-full rounded-md border border-transparent bg-white py-3 px-5 text-center text-base font-medium text-amber-500 shadow-md hover:bg-gray-50 sm:inline-block sm:w-auto"
                               href="{{ $currentModal?->link }}" target="_blank">Link zur Anmeldung</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled">
            @lang('Done')
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>
