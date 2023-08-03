<div class="flex flex-col space-y-1">
    <a href="{{ $row->link }}" target="_blank">
        <x-badge class="whitespace-nowrap">{{ __('Link') }}</x-badge>
    </a>
    <div>
        @can('update', $row)
            <x-button primary xs :href="route('bitcoinEvent.form', ['bitcoinEvent' => $row])">
                <i class="fa-solid fa-edit"></i>
                {{ __('Edit') }}
            </x-button>
        @endif
    </div>
</div>
