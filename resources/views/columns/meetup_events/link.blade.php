<div class="flex flex-col space-y-1">
    <div>
        <x-button
            class="whitespace-nowrap"
            primary
            xs
            :href="route('meetup.event.landing', ['country' => $row->meetup->city->country, 'meetupEvent' => $row->id])"
        >
            <i class="fa fa-thin fa-browser mr-2"></i>
            {{ __('Link to participate') }}
        </x-button>
    </div>
    @if($row->meetup->telegram_link)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->telegram_link"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Telegram-Link') }}
            </x-button>
        </div>
    @endif
    @if($row->meetup->webpage)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->webpage"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Website') }}
            </x-button>
        </div>
    @endif
    @if($row->meetup->twitter_username)
        <div>
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->twitter_username"
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
</div>
