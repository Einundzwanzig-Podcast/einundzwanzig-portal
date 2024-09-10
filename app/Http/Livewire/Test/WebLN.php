<?php

namespace App\Http\Livewire\Test;

use App\Traits\LNBitsTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WebLN extends Component
{
    use LNBitsTrait;

    public $invoice;

    public bool $paymentDone = false;

    public function mount()
    {
        $this->invoice = $this->createInvoice(
            sats: 1,
            memo: 'Test Payment from WebLN',
            lnbits: [
                'read_key' => '97f6120563e3498b8be4c67023c912ae',
                'url' => 'https://bits.codingarena.top',
            ]
        );
    }

    public function success()
    {
        $this->paymentDone = true;
    }

    public function reloadMe()
    {
        // full reload current page
        return redirect()->route('webln');
    }

    public function logThis($text)
    {
        Log::info('WEBLN: ' . $text);
    }

    public function render()
    {
        return view('livewire.test.web-l-n')->layout('layouts.test');
    }
}
