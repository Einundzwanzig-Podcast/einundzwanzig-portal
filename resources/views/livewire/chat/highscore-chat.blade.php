<div x-cloak x-data="{ open: @entangle('open') }" x-show="open" class="relative z-50"
     aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div class="fixed inset-0 overflow-hidden backdrop-blur-sm">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md"
                     x-description="Slide-over panel, show/hide based on slide-over state."
                     x-trap.noscroll="open"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="bg-amber-700 py-6 px-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">{{ __('PlebChat') }}</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button"
                                            class="rounded-md bg-amber-700 text-amber-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            @click="open = false">
                                        <span class="sr-only">{{ __('Close panel') }}</span>
                                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x-mark"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-1">
                                <p class="text-sm text-gray-900">
                                    {{ __('This chat is limited by 21 messages.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex-1">
                            <!-- Replace with your content -->
                            <div class="absolute inset-0">
                                <div class="flex antialiased text-gray-800 h-full">
                                    <div class="flex flex-row w-full overflow-x-hidden">
                                        <div class="flex flex-col flex-auto">
                                            <div
                                                class="flex flex-col h-full flex-auto flex-shrink-0 bg-21gray p-4"
                                            >
                                                <div
                                                    x-data="{ scroll: () => { $el.scrollTo(0, $el.scrollHeight); }}"
                                                    @chat-updated.window="scroll()"
                                                    x-intersect="scroll()"
                                                    class="flex flex-col overflow-x-auto mb-4">
                                                    <div class="flex flex-col">
                                                        <div class="grid grid-cols-12 gap-y-2">

                                                            @php
                                                                $myMessageClass = 'col-start-1 col-end-8 p-3 rounded-lg';
                                                                $otherMessageClass = 'col-start-6 col-end-13 p-3 rounded-lg';
                                                            @endphp

                                                            @foreach($messages as $message)
                                                                <div class="{{ auth()->id() === $message['fromId'] ? $myMessageClass : $otherMessageClass }}">
                                                                    <div class="flex flex-row items-center">
                                                                        <div
                                                                            class="flex items-center justify-center h-10 w-10 rounded-full flex-shrink-0"
                                                                        >
                                                                            <img class="object-cover rounded" src="{{ $message['userImg'] }}" alt="{{ $message['fromName'] }}">
                                                                        </div>
                                                                        <div
                                                                            class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"
                                                                        >
                                                                            <div>
                                                                                <p>
                                                                                    {{ $message['message'] }}
                                                                                </p>
                                                                                <p class="text-xs text-gray-400 italic">
                                                                                    {{ $message['time'] }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4"
                                                >
                                                    <div class="flex-grow ml-4">
                                                        <form wire:submit.prevent="sendMessage">
                                                            <div class="relative w-full">
                                                                <input
                                                                    wire:model.defer="myNewMessage"
                                                                    type="text"
                                                                    class="flex w-full border rounded-xl focus:outline-none focus:border-amber-300 pl-4 h-10"
                                                                />
                                                                @error('myNewMessage')<p
                                                                    class="text-red-500 text-xs">{{ $message }}</p>@enderror
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="ml-4">
                                                        <button
                                                            wire:click="sendMessage"
                                                            class="flex items-center justify-center bg-amber-500 hover:bg-amber-600 rounded-xl text-white px-4 py-1 flex-shrink-0"
                                                        >
                                                            <span>{{ __('Send') }}</span>
                                                            <span class="ml-2">
                                                              <i class="fa-thin fa-envelope w-4 h-4 transform rotate-45 -mt-px"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /End replace -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
