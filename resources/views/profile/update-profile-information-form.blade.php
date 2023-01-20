<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            "/>

                <x-jet-label for="photo" value="{{ __('Photo') }}"/>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                         class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2"/>
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}"/>
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                         autocomplete="name"/>
            <x-jet-input-error for="name" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <p class="text-xs">{{ __('Only one working address is required. But you can also fill in all fields if you have suitable data.') }}</p>
        </div>

        <!-- lightning_address -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="lightning_address" value="{{ __('Lightning Address') }}"/>
            <x-jet-input id="lightning_address" type="text" class="mt-1 block w-full"
                         wire:model.defer="state.lightning_address"
                         autocomplete="lightning_address"/>
            <p class="text-xs">{{ __('for example xy@getalby.com') }}</p>
            <x-jet-input-error for="lightning_address" class="mt-2"/>
        </div>

        <!-- lnurl -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="lnurl" value="{{ __('LNURL') }}"/>
            <x-jet-input id="lnurl" type="text" class="mt-1 block w-full" wire:model.defer="state.lnurl"
                         autocomplete="lnurl"/>
            <p class="text-xs">{{ __('starts with: lnurl1dp68gurn8gh....') }}</p>
            <x-jet-input-error for="lnurl" class="mt-2"/>
        </div>

        <!-- node_id -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="node_id" value="{{ __('Node Id') }}"/>
            <x-jet-input id="node_id" type="text" class="mt-1 block w-full" wire:model.defer="state.node_id"
                         autocomplete="node_id"/>
            <x-jet-input-error for="node_id" class="mt-2"/>
        </div>

        <!-- Email -->
        {{--<div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}"/>
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email"/>
            <x-jet-input-error for="email" class="mt-2"/>

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !$this->user->hasVerifiedEmail() && $this->user->email)
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900"
                            wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>--}}

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="timezone" value="{{ __('Timezone') }}"/>
            <x-select :clearable="false" wire:model.defer="state.timezone" id="timezone"
                      :options="collect(Timezonelist::toArray(false))->collapse()->keys()"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
