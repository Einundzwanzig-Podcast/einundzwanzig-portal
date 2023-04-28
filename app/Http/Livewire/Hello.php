<?php

namespace App\Http\Livewire;

use App\Traits\LNBitsTrait;
use Illuminate\Support\Facades\File;
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
            'message' => 'required|string|max:255',
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
                    'url'       => 'https://legend.lnbits.com',
                    'wallet_id' => 'b9b095edd0db4bf8995f1bbc90b195c5',
                    'read_key'  => '67e6d7f94f5345119d6c799d768a029e',
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
                                            ->merge('/public/img/einundzwanzig.png', .3)
                                            ->errorCorrection('H')
                                            ->generate($invoice['payment_request']));
        $this->invoice = $invoice['payment_request'];
        $this->checkid = $invoice['checking_id'];
    }

    public function checkPaymentHash()
    {
        try {
            $invoice = $this->check($this->checkid, [
                'url'       => 'https://legend.lnbits.com',
                'wallet_id' => 'b9b095edd0db4bf8995f1bbc90b195c5',
                'read_key'  => '67e6d7f94f5345119d6c799d768a029e',
            ]);
        } catch (\Exception $e) {
            $this->notification()
                 ->error('LNBits error: '.$e->getMessage());

            return;
        }
        if (isset($invoice['paid']) && $invoice['paid']) {
            $this->invoicePaid = true;

        } else {
            Log::error(json_encode($invoice, JSON_THROW_ON_ERROR));
        }
    }

    public function render()
    {
        return view('livewire.hello')->layout('layouts.guest');
    }
}