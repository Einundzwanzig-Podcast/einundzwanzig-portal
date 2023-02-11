<div class="container p-4 mx-auto bg-21gray my-2">

    <div class="pb-5 flex flex-row justify-between">
        <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('News Article') }}</h3>
        <div class="flex flex-row space-x-2 items-center">
            <div>
                <x-button :href="route('article.overview', ['country' => null])">
                    <i class="fa fa-thin fa-arrow-left"></i>
                    {{ __('Back') }}
                </x-button>
            </div>
        </div>
    </div>

    <form class="space-y-8 divide-y divide-gray-700 pb-24">
        <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
            <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                <x-input.group :for="md5('libraryItem.lecturer_id')">
                    <x-slot name="label">
                        <div class="flex flex-row space-x-4 items-center">
                            <div>
                                {{ __('Author') }}
                            </div>
                            <x-button xs href="/nova/resources/lecturers/new" target="_blank">
                                <i class="fa fa-thin fa-plus"></i>
                                {{ __('Create new author') }}
                            </x-button>
                        </div>
                    </x-slot>
                    <x-select
                        :clearable="false"
                        wire:model="libraryItem.lecturer_id"
                        :searchable="true"
                        :async-data="[
                            'api' => route('api.lecturers.index'),
                            'method' => 'GET', // default is GET
                        ]"
                        :template="[
                            'name'   => 'user-option',
                            'config' => ['src' => 'image']
                        ]"
                        option-label="name"
                        option-value="id"
                    />
                </x-input.group>

                @if($libraryItem->lecturer_id)
                    <x-input.group :for="md5('image')" :label="__('Main picture')">
                        <div class="py-4">
                            @if ($image)
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($libraryItem->getFirstMediaUrl('main'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $libraryItem->getFirstMediaUrl('main') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.main_image_caption')" :label="__('Main image caption')">
                        <x-input autocomplete="off" wire:model.debounce="libraryItem.main_image_caption"
                                 :placeholder="__('Main image caption')"
                                 :cornerHint="__('Ex: Photo by Timothy Vollmer/ CC BY')"/>
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.name')" :label="__('Title')">
                        <x-input autocomplete="off" wire:model.debounce="libraryItem.name"
                                 :placeholder="__('Title')"/>
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.subtitle')" :label="__('Subtitle')">
                        <x-input autocomplete="off" wire:model.debounce="libraryItem.subtitle"
                                 :placeholder="__('Subtitle')"/>
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.excerpt')" :label="__('Excerpt')">
                        <x-textarea autocomplete="off" wire:model.debounce="libraryItem.excerpt"
                                    :placeholder="__('Excerpt')"/>
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.language_code')" :label="__('Language Code')">
                        <x-select
                            :clearable="false"
                            wire:model="libraryItem.language_code"
                            :options="collect(config('languages.languages'))->map(fn($value, $key) => ['id' => $key, 'name' => $value])->toArray()"
                            option-label="name"
                            option-value="id"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.value')" :label="__('Article as Markdown')">
                    <span
                        class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</span>
                        <x-input.simple-mde wire:model.defer="libraryItem.value"/>
                        @error('libraryItem.value') <span class="text-red-500 py-2">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('libraryItem.read_time')" :label="__('Time to read')">
                        <x-inputs.number min="1" autocomplete="off" wire:model.debounce="libraryItem.read_time"
                                         :placeholder="__('Time to read')" :hint="__('How many minutes to read?')"/>
                    </x-input.group>

                    <x-input.group :for="md5('meetupEvent.link')" label="">
                        <x-button primary wire:click="save">
                            <i class="fa fa-thin fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>
                @endif

            </div>
        </div>
    </form>
</div>
