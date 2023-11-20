<div x-data="nostrStart(@this)">

    <div class="flex flex-col">
        @if($user)
           @foreach($user->meetups as $meetup)
               <div>
                   {{ $meetup->name }}
               </div>
           @endforeach
        @endif
    </div>
</div>
