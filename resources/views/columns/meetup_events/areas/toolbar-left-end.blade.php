<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('meetup.event.form', ['country' => $country, 'meetupEvent' => null])">
        <i class="fa fa-thin fa-plus"></i>
        {{ __('Register Meetup date') }}
    </x-button>
    <x-button :href="route('profile.meetups', ['country' => $country])">
        <i class="fa fa-thin fa-user-group"></i>
        {{ __('My meetups') }}
    </x-button>
</div>
