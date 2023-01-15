<x-jet-dialog-modal wire:model="viewingModal" maxWidth="screen" bg="bg-21gray">
    <x-slot name="title">
        <div class="text-gray-200">
            {{ __('Registration') }}
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="relative py-16">
            <div class="absolute inset-x-0 top-0 hidden h-1/2 lg:block" aria-hidden="true"></div>
            <div class="mx-auto max-w-7xl bg-21gray lg:bg-transparent lg:px-8">
                <div class="lg:grid lg:grid-cols-12">
                    <div class="hidden sm:inline-flex relative z-10 lg:col-span-4 lg:col-start-1 lg:row-start-1 lg:bg-transparent lg:py-16">
                        <div class="absolute inset-x-0 h-1/2 lg:hidden" aria-hidden="true"></div>
                        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-none lg:p-0 space-y-2">
                            <div class="w-48 h-48">
                                <img class="rounded-3xl object-cover object-center shadow-2xl w-48 h-48"
                                     src="{{ $currentModal?->course->getFirstMediaUrl('logo') }}"
                                     alt="{{ $currentModal?->course->name }}">
                            </div>
                            @foreach($currentModal?->course->getMedia('images') ?? [] as $image)
                                <div class="w-48 h-48">
                                    <img class="rounded-3xl object-cover object-center shadow-2xl w-48 h-48"
                                         src="{{ $image->getUrl('preview') }}"
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
                            <div class="flex items-center justify-between">
                                <h2 class="text-3xl font-bold tracking-tight text-white"
                                    id="join-heading">{{ __('Lecturer') }}: {{ $currentModal?->course->lecturer->name }}</h2>
                                <img class="w-12 h-12 object-cover rounded"
                                     src="{{ $currentModal?->course->lecturer->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $currentModal?->course->lecturer->name }}"/>
                            </div>
                            <h2 class="text-3xl font-bold tracking-tight text-white"
                                id="join-heading">{{ __('Von') }}: {{ $currentModal?->from->asDateTime() }}</h2>
                            <h2 class="text-3xl font-bold tracking-tight text-white"
                                id="join-heading">{{ __('Bis') }}: {{ $currentModal?->to->asDateTime() }}</h2>
                            <a class="block w-full rounded-md border border-transparent bg-white py-3 px-5 text-center text-base font-medium text-amber-500 shadow-md hover:bg-gray-50 sm:inline-block sm:w-auto"
                               href="{{ $currentModal?->link }}" target="_blank">{{ __('Link to the registration') }}</a>
                            <div class="prose-xl prose-white">
                                <x-markdown>
                                    {!! $currentModal?->course->description !!}
                                </x-markdown>
                            </div>
                            <a class="block w-full rounded-md border border-transparent bg-white py-3 px-5 text-center text-base font-medium text-amber-500 shadow-md hover:bg-gray-50 sm:inline-block sm:w-auto"
                               href="{{ $currentModal?->link }}" target="_blank">{{ __('Link to the registration') }}</a>
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
