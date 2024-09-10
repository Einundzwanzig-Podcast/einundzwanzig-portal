<div x-data="webln(@this)" class="p-2 sm:p-4" wire:ignore>
    <div class="font-mono space-y-1 p-2 sm:p-4 text-white break-words">
        <div class="text-xs sm:text-base break-words">Test Payment from WebLN to "Bob"</div>
        <div class="text-xs sm:text-base break-words">1 sat</div>
        <div class="text-xs sm:text-base break-words">keysend to: 0363662a4ae8b8b7a73d9f4e459a9b25d4786f4ecc7315b5401934f3a2ef609750</div>
        <div class="mt-6">
            <div class="flex justify-center">
                <button x-on:click="keySendMethod" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pay</button>
            </div>
        </div>
    </div>
</div>
