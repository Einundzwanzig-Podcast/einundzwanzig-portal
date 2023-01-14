<div>
    @if($row->meetup_events_count > 0)
        <x-button
            amber
            wire:click="meetupEventSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>

        <x-button
            x-data="{
                    textToCopy: '{{ route('meetup.ics', ['country' => $country, 'meetup' => $row->id]) }}',
                    }"
            @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
            amber>
            <i class="fa fa-thin fa-calendar-arrow-down mr-2"></i>
            {{ __('Calendar Stream-Url') }} ({{ $row->meetup_events_count }})
        </x-button>
    @endif
    @if($row->meetup_events_count < 1)
        <x-button
            outlined
            wire:click="meetupEventSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar-circle-exclamation mr-2"></i>
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>
    @endif
    <x-button
        primary
        :href="route('meetup.landing', ['country' => $country, 'meetup' => $row->slug])"
    >
        <i class="fa fa-thin fa-browser mr-2"></i>
        {{ __('Show landing page') }}
    </x-button>
</div>
