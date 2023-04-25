<div>
    <div
        class="mt-10 flex flex-col items-center justify-center gap-x-6 bg-white pb-12">
        @if(!$invoicePaid)
            <div class="text-xl font-semibold text-gray-900 py-6 px-2">
                Deine Nachricht wird live vorgelesen.
                Fülle zuerst das Textfeld mit deiner Nachricht aus
                und bezahle erst danach mit Lightning.
            </div>
            <div class="text-xl font-semibold text-gray-900 py-6 w-full px-12">
                <x-textarea wire:model="message" label="Deine Nachricht hier" corner-hint="max. 255 Zeichen"/>
            </div>
            <div class="text-xl font-semibold text-gray-900 py-6 px-2">
                {{ __('Click QR-Code to open your wallet') }}
            </div>
            <div class="flex justify-center" wire:key="qrcode">
                <a href="lightning:{{ $this->invoice }}">
                    <img src="{{ 'data:image/png;base64, '. $this->qrCode }}"
                         alt="qrcode">
                </a>
            </div>
            <div class="text-xl font-semibold text-gray-900 py-6">
                21 sats
            </div>
            <div wire:poll.keep-alive="checkPaymentHash"
                 wire:key="checkPaymentHash"></div>
        @else
            <div class="text-xl font-semibold text-gray-900 py-6">
                Danke für deine Nachricht. Wenn alles klappt, dann werden wir die Nachricht gleich hören.
            </div>
        @endif
    </div>
</div>
