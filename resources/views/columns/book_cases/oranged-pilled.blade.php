<div class="flex flex-col space-y-1">
    @auth
        @if($row->orange_pilled)
            <img class="aspect-auto max-h-12" src="{{ asset('img/social_credit_plus.webp') }}" alt="">
        @endif
        @if(!$row->orange_pilled)
            <img class="aspect-auto max-h-12" src="{{ asset('img/social_credit_minus.webp') }}" alt="">
        @endif
        <div class="flex items-center space-x-1">
            <x-button wire:click="viewHistoryModal({{ $row->id }})">💊 Orange Pill Now</x-button>
            <x-button :href="route('comment.bookcase', ['bookCase' => $row->id])">Kommentare</x-button>
        </div>
    @else
        <div>
            <x-badge amber>
                <i class="fa fa-thin fa-shelves-empty mr-2"></i>
                {{ __('noch keine Bitcoin-Bücher') }}
            </x-badge>
        </div>
    @endauth
</div>
