<?php

namespace App\Http\Livewire\Banner;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MempoolWeather extends Component
{
    public string $weather = '';

    public $fastestFee;
    public $halfHourFee;
    public $hourFee;
    public $economyFee;
    public $minimumFee;

    public function mount()
    {
        if (cache()->has('mempool-weather')) {
            $this->weather = cache()->get('mempool-weather');
        } else {
            Artisan::call('test');
            $this->weather = cache()->get('mempool-weather');
        }
        $result = Http::get('https://mempool.space/api/v1/fees/recommended');
        $result = $result->json();
        $this->fastestFee = $result['fastestFee'];
        $this->halfHourFee = $result['halfHourFee'];
        $this->hourFee = $result['hourFee'];
        $this->economyFee = $result['economyFee'];
        $this->minimumFee = $result['minimumFee'];
    }

    public function render()
    {
        return view('livewire.banner.mempool-weather');
    }
}
