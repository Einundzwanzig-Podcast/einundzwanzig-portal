<x-jet-dialog-modal wire:model="viewingModal" maxWidth="screen" bg="bg-21gray">
    <x-slot name="title">
        <div class="text-gray-200">
            {{ __('Orange Pill Book Case') }}
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4 mt-16 flex flex-col justify-center">
            <div class="col-span-6 sm:col-span-4">
                <x-input
                    min="1"
                    type="number"
                    wire:model.debounce="orangepill.amount"
                    label="Anzahl der Bücher"
                    placeholder="Anzahl der Bücher"
                    corner-hint="Wie viele Bitcoin-Bücher hast du reingestellt?"
                />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-datetime-picker
                    label="Datum"
                    placeholder="Datum"
                    display-format="DD.MM.YYYY"
                    wire:model.defer="orangepill.date"
                    without-time
                    corner-hint="Wann hast du Bitcoin-Bücher reingestellt?"
                />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-textarea wire:model.defer="orangepill.comment" label="Kommentar" placeholder="Kommentar"
                            corner-hint="Zum Beispiel welche Bücher du reingestellt hast."/>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled">
            💊 @lang('Orange Pill Now')
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>
