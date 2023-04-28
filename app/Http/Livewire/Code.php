<?php

namespace App\Http\Livewire;

use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Code extends Component
{
    public function render()
    {

        $qrCode = base64_encode(QrCode::format('png')
                                            ->size(500)
                                            ->merge('/public/img/einundzwanzig.png', .3)
                                            ->errorCorrection('H')
                                            ->generate('https://portal.einundzwanzig.space/hello'));

        return view('livewire.code', [
            'qrCode' => $qrCode,
        ]);
    }
}
