<div class="flex flex-col space-y-1">
    <div>
        @if(auth()->user()->can('update', $row))
            <x-button
                black
                xs
                :href="route('meetup.event.form', ['country' => $row->meetup->city->country, 'meetupEvent' => $row])"
            >
                <i class="fa fa-solid fa-edit mr-2"></i>
                {{ __('Edit') }}
            </x-button>
        @else
            <x-badge>{{ __('no authorization') }}</x-badge>
        @endif
    </div>
</div>
