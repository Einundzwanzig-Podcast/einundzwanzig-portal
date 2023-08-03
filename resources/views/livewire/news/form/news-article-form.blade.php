<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            @if($paid)
                <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Paid News Article') }}</h3>
            @else
                <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('News Article') }}</h3>
            @endif
            <div class="flex flex-row space-x-2 items-center justify-between">
                <div x-data="{}">
                    @if($libraryItem->created_by === auth()->id())
                        <x-button
                            x-on:click="$wireui.confirmDialog({
                            icon: 'question',
                            title: '{{ __('Are your sure?') }}',
                            accept: {label: '{{ __('Yes') }}',
                            execute: () => $wire.delete()},
                            reject: {label: '{{ __('No, cancel') }}',
                    }})"
                            negative>
                            <i class="fa fa-solid fa-trash"></i>
                            {{ __('Delete') }}
                        </x-button>
                    @endif
                </div>
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

                    @if($paid)
                        <x-input.group :for="md5('libraryItem.sats')" :label="__('sats')">
                            <x-inputs.number min="21" autocomplete="off" wire:model.debounce="libraryItem.sats"
                                             :placeholder="__('sats')"
                                             :hint="__('How many sats to read this article?')"/>
                        </x-input.group>
                    @endif

                    <x-input.group :for="md5('libraryItem.lecturer_id')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('Author') }}
                                </div>
                                <x-button xs href="{{ route('contentCreator.form', ['country' => 'de']) }}">
                                    <i class="fa fa-solid fa-plus"></i>
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
                                'params' => ['user_id' => auth()->id()], // default is []
                            ]"
                            :template="[
                                'name'   => 'user-option',
                                'config' => ['src' => 'image']
                            ]"
                            option-label="name"
                            option-value="id"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('selectedTags')" :label="__('Tags')">
                        <x-slot name="label">
                            <div class="flex flex-row space-x-4 items-center">
                                <div>
                                    {{ __('Tags') }}
                                </div>
                                @if(!$addTag)
                                    <x-button
                                        xs
                                        wire:click="$set('addTag', true)"
                                    >
                                        <i class="fa fa-solid fa-plus"></i>
                                        {{ __('Add') }}
                                    </x-button>
                                @else
                                    <x-input label="" wire:model.debounce="newTag" placeholder="{{ __('New tag') }}"/>
                                    <x-button
                                        xs
                                        wire:click="addTag">
                                        <i class="text-xl fa-solid fa-save"></i>
                                    </x-button>
                                @endif
                            </div>
                        </x-slot>
                        <div class="flex flex-col">
                            <div class="py-2 flex flex-wrap items-center space-x-1">
                                @foreach($tags as $tag)
                                    <div class="cursor-pointer" wire:key="tag{{ $loop->index }}"
                                         wire:click="selectTag('{{ $tag['name'] }}')">
                                        @if(collect($selectedTags)->contains($tag['name']))
                                            <x-badge
                                                amber>
                                                {{ $tag['name'] }}
                                            </x-badge>
                                        @else
                                            <x-badge
                                                black>
                                                {{ $tag['name'] }}
                                            </x-badge>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedTags')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </x-input.group>

                    @if($libraryItem->lecturer_id)
                        <x-input.group :for="md5('image')" :label="__('Main picture')">
                            <div class="py-4">
                                @if ($image && str($image->getMimeType())->contains(['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']))
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

                        <x-input.group :for="md5('libraryItem.value')"
                                       :label="$paid ? __('Free part of the Article as Markdown') : __('Article as Markdown')">
                            <div
                                class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                            <x-input.simple-mde wire:model.defer="libraryItem.value"/>
                            @error('libraryItem.value') <span class="text-red-500 py-2">{{ $message }}</span> @enderror
                        </x-input.group>

                        @if($paid)
                            <x-input.group :for="md5('libraryItem.value_to_be_paid')"
                                           :label="__('Part of the article to be paid')">
                                <div
                                    class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                                <x-input.simple-mde wire:model.defer="libraryItem.value_to_be_paid"/>
                                @error('libraryItem.value_to_be_paid') <span
                                    class="text-red-500 py-2">{{ $message }}</span> @enderror
                            </x-input.group>
                        @endif

                        <x-input.group :for="md5('libraryItem.read_time')" :label="__('Time to read')">
                            <x-inputs.number min="1" autocomplete="off" wire:model.debounce="libraryItem.read_time"
                                             :placeholder="__('Time to read')" :hint="__('How many minutes to read?')"/>
                        </x-input.group>

                        <x-input.group :for="md5('meetupEvent.link')" label="">
                            <x-button primary wire:click="save">
                                <i class="fa fa-solid fa-save"></i>
                                {{ __('Save') }}
                            </x-button>
                        </x-input.group>
                    @endif

                </div>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
