<div class="flex flex-col space-y-1">
    <div>
        <x-button
            black
            xs
            :href="route('meetup.landing', ['country' => $country, 'meetup' => $row->meetup->slug])"
        >
            <i class="fa fa-thin fa-browser mr-2"></i>
            {{ __('Show landing page') }}
        </x-button>
    </div>
    <div>
        @if($row->meetup->telegram_link)
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->telegram_link"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Telegram-Link') }}
            </x-button>
        @endif
    </div>
    <div>
        @if($row->meetup->webpage)
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->webpage"
            >
                <i class="fa fa-thin fa-external-link mr-2"></i>
                {{ __('Website') }}
            </x-button>
        @endif
    </div>
    <div>
        @if($row->meetup->twitter_username)
            <x-button
                xs
                black
                target="_blank"
                :href="$row->meetup->twitter_username"
            >
                <i class="fa fa-brand fa-twitter mr-2"></i>
                {{ __('Twitter') }}
            </x-button>
        @endif
    </div>
</div>
