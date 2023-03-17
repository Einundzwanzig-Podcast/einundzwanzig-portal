<div class="flex flex-col space-y-1">
    @if($row->meetup_events_count > 0)
        <div>
            <x-button
                xs
                amber
                wire:click="meetupEventSearch({{ $row->id }})">
                <i class="fa fa-thin fa-calendar mr-2"></i>
                {{ __('Show dates') }} ({{ $row->meetup_events_count }})
            </x-button>
        </div>
    @endif
    @if($row->meetup_events_count < 1)
        <div>
            <x-button
                xs
                outlined
                wire:click="meetupEventSearch({{ $row->id }})">
                <i class="fa fa-thin fa-calendar-circle-exclamation mr-2"></i>
                {{ __('Show dates') }} ({{ $row->meetup_events_count }})
            </x-button>
        </div>
    @endif
    <div>
        <x-button
            xs
            black
            x-data="{}"
            @click.prevent="window.navigator.clipboard.writeText('{{ $ics }}');window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
        >
            <i class="fa fa-thin fa-calendar-arrow-down mr-2"></i>
            {{ __('Calendar Stream-Url') }} ({{ $row->meetup_events_count }})
        </x-button>
    </div>
    <div>
        <x-button
            black
            xs
            :href="route('meetup.landing', ['country' => $country ?? $row->city->country->code, 'meetup' => $row->slug])"
        >
            <i class="fa fa-thin fa-browser mr-2"></i>
            {{ __('Show landing page') }}
        </x-button>
    </div>
    @if($row->telegram_link)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->telegram_link"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Telegram-Link') }}
            </x-button>
        </div>
    @endif
    @if($row->webpage)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->webpage"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Website') }}
            </x-button>
        </div>
    @endif
    @if($row->twitter_username)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->twitter_username"
            >
                <i class="fa fa-brand fa-twitter mr-2"></i>
                {{ __('Twitter') }}
            </x-button>
        </div>
    @endif
    @if($row->nostr)
        <div
            x-data="{
                      textToCopy: '{{ $row->nostr }}',
                    }"
            @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('PubKey copied!') }}',icon:'success'});"
        >
            <x-button
                xs
                black
            >
                <i class="fa fa-thin fa-clipboard mr-2"></i>
                {{ __('Nostr') }}
            </x-button>
        </div>
    @endif
    @can('update', $row)
        <div>
            <x-button
                :href="route('meetup.meetup.form', ['meetup' => $row->id, 'country' => $country])"
                xs
                amber
            >
                <i class="fa fa-thin fa-edit mr-2"></i>
                {{ __('Edit') }}
            </x-button>
        </div>
    @endcan
</div>
