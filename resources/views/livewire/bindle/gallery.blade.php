<div class="bg-21gray flex flex-col h-screen">
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="mx-auto max-w-screen-2xl px-4 py-10 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row">

            <div>
                <div class="py-6">
                    @if(auth()->id() === config('portal.bonus.fiat-tracker-user-id'))
                        <x-button icon="plus"
                                  :href="route('library.libraryItem.form', ['country' => 'de'])">
                            {{ __('Neues Bindle hochladen') }}
                        </x-button>
                    @endif
                </div>

                <div>
                    <h1 class="text-4xl text-white py-8">Sent from my #₿indle🧡</h1>

                    <ul role="list"
                        class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">

                        @foreach($bindles as $bindle)
                            <li wire:key="image_{{ $bindle->id }}">
                                <div>
                                    <div
                                        class="aspect-h-7 aspect-w-10 block w-full rounded-lg bg-gray-100">
                                        <a target="_blank" href="{{ $bindle->getFirstMediaUrl('main') }}">
                                            <img src="{{ $bindle->getFirstMediaUrl('main') }}" alt="{{ $bindle->name }}"
                                                 class="object-cover">
                                        </a>
                                        <button type="button" class="absolute inset-0 focus:outline-none">
                                            <span class="sr-only">{{ $bindle->name }}</span>
                                        </button>
                                    </div>
                                    <p class="mt-2 block truncate text-sm font-medium text-gray-100">{{ $bindle->name }}</p>
                                    <div>
                                        <a href="{{ $bindle->value }}" target="_blank" class="text-md font-medium text-gray-100">{{ $bindle->value }}</a>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-100 py-4">
                                    @if(auth()->id() === config('portal.bonus.fiat-tracker-user-id'))
                                        <x-button
                                            negative
                                            xs
                                            icon="trash"
                                            label="{{ __('Delete') }}"
                                            x-on:confirm="{
                                                title: 'Are you sure you want to delete this bindle?',
                                                icon: 'warning',
                                                method: 'deleteBindle',
                                                params: {{ $bindle->id }}
                                            }"
                                        />
                                    @endif
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div>
                <div wire:ignore>
                    <div
                        class="flex flex-col justify-center text-center space-x-4 py-4 mt-4">

                            <h1 class="text-2xl text-gray-200">value-4-value</h1>
                            <div wire:ignore>
                                <lightning-widget
                                    name="fiattracker"
                                    accent="#f7931a"
                                    to="fiattracker@current.tips"
                                    image="https://primal.b-cdn.net/media-cache?s=m&a=1&u=https%3A%2F%2Fphoto.starbackr.com%2F6398268f7354d37fe0b31829%2Fprofile%2F1674719214461.jpg"
                                    amounts="21,210,2100,21000"
                                />
                            </div>
                    </div>

                    <script src="https://embed.twentyuno.net/js/app.js"></script>
                </div>
            </div>

        </div>

    </div>
</div>
