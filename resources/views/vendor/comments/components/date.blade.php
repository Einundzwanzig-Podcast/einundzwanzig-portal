<time datetime="$date->format('Y-m-d H:i:s')" class="comments-date">
    @if($date->diffInMinutes() < 1)
        {{ __('comments::comments.just_now') }}
    @else
        {{ $date->diffForHumans() }}
    @endif
</time>
