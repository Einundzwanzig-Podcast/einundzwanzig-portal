<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('venue.form', ['country' => $country, 'venue' => null])">
        <i class="fa fa-thin fa-plus"></i>
        {{ __('Create venue') }}
    </x-button>
</div>
