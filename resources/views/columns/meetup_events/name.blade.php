<a href="{{ route('meetup.event.landing', ['country' => $country, 'meetupEvent' => $row]) }}">
    <div class="flex items-center space-x-2">
        <img class="h-12" src="{{ $row->meetup->getFirstMediaUrl('logo', 'thumb') }}" alt="{{ $row->meetup->name }}">
        <div>
            {{ $row->meetup->name }}
        </div>
    </div>
</a>
