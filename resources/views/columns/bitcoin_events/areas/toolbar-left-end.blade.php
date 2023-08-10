<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('bitcoinEvent.form', ['country' => $country, 'bitcoinEvent' => null])">
        <i class="fa fa-thin fa-plus"></i>
        {{ __('Register event') }}
    </x-button>
</div>
