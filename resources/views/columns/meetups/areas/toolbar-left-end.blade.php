<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('meetup.meetup.form', ['country' => $country, 'meetup' => null])">
        <i class="fa fa-solid fa-plus"></i>
        {{ __('Submit Meetup') }}
    </x-button>
    <x-button :href="route('profile.meetups', ['country' => $country])">
        <i class="fa fa-solid fa-user-group"></i>
        {{ __('My meetups') }}
    </x-button>
</div>
