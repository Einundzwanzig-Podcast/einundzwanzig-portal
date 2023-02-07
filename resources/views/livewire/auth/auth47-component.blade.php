<div class="bg-white flex flex-col h-screen justify-between py-16">
    <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">
        <div class="flex flex-col space-y-4">
            <div class="flex justify-center" wire:key="qrcode">
                <a href="{{ $this->url }}">
                    <img src="{{ 'data:image/png;base64, '. $this->qrCode }}" alt="qrcode">
                </a>
            </div>
            <code class="font-mono text-black">
                {{ $this->url }}
            </code>
        </div>
    </div>
</div>
