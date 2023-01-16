<div>
    @if($row->meetup_events_count > 0)
        <x-button
            xs
            amber
            wire:click="meetupEventSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>

        <x-button
            xs
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
            xs
            outlined
            wire:click="meetupEventSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar-circle-exclamation mr-2"></i>
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>
    @endif
    <x-button
        black
        xs
        :href="route('meetup.landing', ['country' => $country, 'meetup' => $row->slug])"
    >
        <i class="fa fa-thin fa-browser mr-2"></i>
        {{ __('Show landing page') }}
    </x-button>
    @if($row->telegram_link)
        <x-button
            xs
            secondary
            target="_blank"
            :href="$row->telegram_link"
        >
            <i class="fa fa-thin fa-external-link mr-2"></i>
            {{ __('Telegram-Link') }}
        </x-button>
    @endif
    @if($row->webpage)
        <x-button
            xs
            secondary
            target="_blank"
            :href="$row->webpage"
        >
            <i class="fa fa-thin fa-external-link mr-2"></i>
            {{ __('Website') }}
        </x-button>
    @endif
    @if($row->twitter_username)
        <x-button
            xs
            secondary
            target="_blank"
            :href="$row->twitter_username"
        >
            <i class="fa fa-brand fa-twitter mr-2"></i>
            {{ __('Twitter') }}
        </x-button>
    @endif
</div>
