<div class="container p-4 mx-auto bg-21gray my-2">

    <div class="pb-5 flex flex-row justify-between">
        <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Book Case') }}: {{ $bookCase->title }}</h3>
        <div class="flex flex-row space-x-2 items-center">
            <div>
                @if($orangePill->id)
                    <x-button negative wire:click="deleteMe">
                        <i class="fa fa-thin fa-trash"></i>
                        {{ __('Delete') }}
                    </x-button>
                @endif
            </div>
            <div>
                <x-button :href="$fromUrl">
                    <i class="fa fa-thin fa-arrow-left"></i>
                    {{ __('Back') }}
                </x-button>
            </div>
        </div>
    </div>

    <form class="space-y-8 divide-y divide-gray-700 pb-24">
        <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
            <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                <x-input.group :for="md5('image')" :label="__('Main picture')">
                    <div class="py-4">
                        @if ($image)
                            <div class="text-gray-200">{{ __('Preview') }}:</div>
                            <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                        @endif
                        @if ($orangePill->getFirstMediaUrl('images'))
                            <div class="text-gray-200">{{ __('Current picture') }}:</div>
                            <img class="h-48 object-contain" src="{{ $orangePill->getFirstMediaUrl('images') }}">
                        @endif
                    </div>
                    <input class="text-gray-200" type="file" wire:model="image">
                    @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                </x-input.group>

                <x-input.group :for="md5('orangePill.amount')" :label="__('Amount')">
                    <x-input
                        min="1"
                        type="number"
                        wire:model.debounce="orangePill.amount"
                        label="{{ __('Number of books') }}"
                        placeholder="{{ __('Number of books') }}"
                        corner-hint="{{ __('How many bitcoin books have you put in?') }}"
                    />
                </x-input.group>

                <x-input.group :for="md5('orangePill.date')" :label="__('Date')">
                    <x-datetime-picker
                        label="{{ __('Date') }}"
                        placeholder="{{ __('Date') }}"
                        wire:model.defer="orangePill.date"
                        timezone="UTC"
                        user-timezone="{{ config('app.user-timezone') }}"
                        corner-hint="{{ __('When did you put bitcoin books in?') }}"
                        without-time
                        display-format="DD.MM.YYYY"
                    />
                </x-input.group>

                <x-input.group :for="md5('orangePill.comment')" :label="__('Comment')">
                    <x-textarea wire:model.defer="orangePill.comment" label="{{ __('Comment') }}" placeholder="{{ __('Comment') }}"
                                corner-hint="{{ __('For example, what books you put in.') }}"/>
                </x-input.group>

                <x-input.group :for="md5('orangePill.save')" label="">
                    <x-button primary wire:click="save">
                        <i class="fa fa-thin fa-save"></i>
                        {{ __('Save') }}
                    </x-button>
                </x-input.group>

            </div>
        </div>
    </form>
</div>
