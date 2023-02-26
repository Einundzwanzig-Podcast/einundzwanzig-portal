<div x-data="Components.popover({ open: false, focus: false })" x-init="init()"
     @keydown.escape="onEscape"
     @close-popover-group.window="onClosePopoverGroup">
    <button type="button"
            class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
            @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
            :aria-expanded="open.toString()">
        {{ __('Settings') }}
        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         x-description="'Product' flyout menu, show/hide based on flyout menu state."
         class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
         x-ref="panel" @click.away="open = false" x-cloak>
        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
            <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-3">
                <h3 class="sr-only">{{ __('Settings') }}</h3>
                <x-select label="{{ __('Timezone') }}" :clearable="false" wire:model.debounce="timezone"
                          id="timezone"
                          :options="collect(Timezonelist::toArray(false))->collapse()->keys()"/>
                <x-native-select
                    label="{{ __('Change country') }}"
                    wire:model="c"
                    option-label="name"
                    option-value="code"
                    :options="$countries"
                />
                <x-select
                    label="{{ __('Change language') }}"
                    wire:model="l"
                    :clearable="false"
                    :searchable="true"
                    :async-data="route('api.languages.index')"
                    option-label="name"
                    option-value="language"
                />

            </div>
        </div>
    </div>
</div>
