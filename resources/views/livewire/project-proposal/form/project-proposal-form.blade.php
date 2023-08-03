<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Project Proposal') }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                <div>
                    <x-button :href="$fromUrl">
                        <i class="fa fa-solid fa-arrow-left"></i>
                        {{ __('Back') }}
                    </x-button>
                </div>
            </div>
        </div>

        <form class="space-y-8 divide-y divide-gray-700 pb-24">
            <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                    <x-input.group :for=" md5('image')" :label="__('Main picture')">
                        <div class="py-4">
                            @if ($image && str($image->getMimeType())->contains(['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']))
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($projectProposal->getFirstMediaUrl('main'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $projectProposal->getFirstMediaUrl('main') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('projectProposal.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="projectProposal.name"
                                 :placeholder="__('Name')"/>
                    </x-input.group>

                    <x-input.group :for="md5('projectProposal.name')" :label="__('Intended support in sats')">
                        <x-input type="number" autocomplete="off" wire:model.debounce="projectProposal.support_in_sats"
                                 :placeholder="__('Intended support in sats')"/>
                    </x-input.group>

                    <x-input.group :for="md5('projectProposal.description')">
                        <x-slot name="label">
                            <div>
                                {{ __('Project description') }}
                            </div>
                            <div
                                class="text-amber-500 text-xs py-2">{{ __('Please write a detailed and understandable application text, so that the vote on a possible support can take place.') }}</div>
                        </x-slot>
                        <div
                            class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                        <x-input.simple-mde wire:model.defer="projectProposal.description"/>
                        @error('projectProposal.description') <span
                            class="text-red-500 py-2">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('save')" label="">
                        <x-button primary wire:click="save">
                            <i class="fa fa-solid fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
