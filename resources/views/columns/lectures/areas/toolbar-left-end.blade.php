<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('contentCreator.form', ['country' => $country, 'lecturer' => null])">
        <i class="fa fa-solid fa-plus"></i>
        {{ __('Register lecturer') }}
    </x-button>
</div>
