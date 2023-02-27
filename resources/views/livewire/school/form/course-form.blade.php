<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Course') }}</h3>
            <div class="flex flex-row space-x-2 items-center">

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

                    <x-input.group :for="md5('image')" :label="__('Logo')">
                        <div class="py-4">
                            @if ($image)
                                <div class="text-gray-200">{{ __('Preview') }}:</div>
                                <img class="h-48 object-contain" src="{{ $image->temporaryUrl() }}">
                            @endif
                            @if ($course->getFirstMediaUrl('logo'))
                                <div class="text-gray-200">{{ __('Current picture') }}:</div>
                                <img class="h-48 object-contain" src="{{ $course->getFirstMediaUrl('logo') }}">
                            @endif
                        </div>
                        <input class="text-gray-200" type="file" wire:model="image">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('lecturer_id')" :label="__('Lecturer')">
                        <x-select
                            :clearable="false"
                            autocomplete="off"
                            wire:model.debounce="course.lecturer_id"
                            :placeholder="__('Lecturer')"
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

                    <x-input.group :for="md5('course.name')" :label="__('Name')">
                        <x-input autocomplete="off" wire:model.debounce="course.name"
                                 :placeholder="__('Name')"
                        />
                    </x-input.group>

                    <x-input.group :for="md5('selectedTags')" :label="__('Tags')">
                        <div class="py-2 flex flex-wrap items-center space-x-1">
                            @foreach($tags as $tag)
                                <div class="cursor-pointer" wire:key="tag{{ $loop->index }}"
                                     wire:click="selectTag('{{ $tag->name }}')">
                                    @if(collect($selectedTags)->contains($tag->name))
                                        <x-badge
                                            amber>
                                            {{ $tag->name }}
                                        </x-badge>
                                    @else
                                        <x-badge
                                            black>
                                            {{ $tag->name }}
                                        </x-badge>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-input.group>

                    <x-input.group :for="md5('course.description')" :label="__('Description')">
                        <div
                            class="text-amber-500 text-xs py-2">{{ __('For images in Markdown, please use eg. Imgur or another provider.') }}</div>
                        <x-input.simple-mde wire:model.defer="course.description"/>
                        @error('course.description') <span
                            class="text-red-500 py-2">{{ $message }}</span> @enderror
                    </x-input.group>

                    <x-input.group :for="md5('save')" label="">
                        <x-button primary wire:click="submit">
                            <i class="fa fa-thin fa-save"></i>
                            {{ __('Save') }}
                        </x-button>
                    </x-input.group>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
