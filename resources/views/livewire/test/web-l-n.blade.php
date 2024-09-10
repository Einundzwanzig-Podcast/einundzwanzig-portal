<div x-data="webln(@this)" class="p-2 sm:p-4">
    <div class="font-mono space-y-1 p-2 sm:p-4 text-white break-words">
        <div wire:ignore>
            <div class="text-xs sm:text-base break-words">Test Payment from WebLN to "The Ben"</div>
            <div class="text-xs sm:text-base break-words">1 sat</div>
            <div class="text-xs sm:text-base break-words">hash: {{ $invoice['payment_hash'] }}</div>
            <div class="text-xs sm:text-base break-words">payment_request: {{ $invoice['payment_request'] }}</div>
        </div>
        <div class="mt-6">
            @if(!$paymentDone)
                <div class="flex justify-center" wire:loading.attr="disabled">
                    <button x-on:click="pay"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Pay Invoice
                    </button>
                </div>
            @else
                <div class="flex justify-center">
                    <div class="text-green-500">
                        Success! Payment done.
                    </div>
                    <button wire:click="reloadMe" wire:loading.attr="disabled"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Reload
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
