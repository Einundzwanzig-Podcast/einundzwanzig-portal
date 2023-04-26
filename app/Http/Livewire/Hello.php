<?php

namespace App\Http\Livewire;

use App\Events\PaidMessageEvent;
use App\Traits\LNBitsTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use WireUi\Traits\Actions;

class Hello extends Component
{
    use Actions;
    use LNBitsTrait;

    public $message = '';
    public $qrCode = '';
    public $invoice = '';
    public $paymentHash = '';
    public $checkid = null;
    public bool $invoicePaid = false;

    public function rules()
    {
        return [
            'message' => 'required|string|max:1000',
        ];
    }

    public function mount()
    {
        try {
            // {"url":"","wallet_id":"","read_key":""}
            $invoice = $this->createInvoice(
                sats: 21,
                memo: 'Payment for: Bitcoin im Ländle 2023 - Code is Speech',
                lnbits: [
                    'url'       => config('services.lnbits.url'),
                    'wallet_id' => config('services.lnbits.wallet_id'),
                    'read_key'  => config('services.lnbits.read_key'),
                ],
            );
        } catch (\Exception $e) {
            $this->notification()
                 ->error('LNBits error: '.$e->getMessage());

            return;
        }

        $this->paymentHash = $invoice['payment_hash'];
        $this->qrCode = base64_encode(QrCode::format('png')
                                            ->size(300)
                                            ->merge('/public/img/markus_turm.png', .3)
                                            ->errorCorrection('H')
                                            ->generate($invoice['payment_request']));
        $this->invoice = $invoice['payment_request'];
        $this->checkid = $invoice['checking_id'];
    }

    public function checkPaymentHash()
    {
        try {
            $invoice = $this->check($this->checkid, [
                'url'       => config('services.lnbits.url'),
                'wallet_id' => config('services.lnbits.wallet_id'),
                'read_key'  => config('services.lnbits.read_key'),
            ]);
        } catch (\Exception $e) {
            $this->notification()
                 ->error('LNBits error: '.$e->getMessage());

            return;
        }
        if (isset($invoice['paid']) && $invoice['paid']) {
            $this->invoicePaid = true;
            event(new PaidMessageEvent($this->message, $this->checkid));
        } else {
            Log::error(json_encode($invoice, JSON_THROW_ON_ERROR));
        }
    }

    public function render()
    {
        return view('livewire.hello')->layout('layouts.guest');
    }
}
