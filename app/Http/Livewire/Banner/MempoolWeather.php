<?php

namespace App\Http\Livewire\Banner;

use App\Console\Commands\MempoolSpace\CacheRecommendedFees;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MempoolWeather extends Component
{
    public $weather;
    public $changed;

    public function mount()
    {
        /*if (cache()->has('mempool-weather')) {
            $this->weather = cache()->get('mempool-weather');
        } else {
            Artisan::call(CacheRecommendedFees::class);
            $this->weather = cache()->get('mempool-weather');
        }
        $this->changed = cache()->get('mempool-weather-changed');*/
    }

    public function render()
    {
        return view('livewire.banner.mempool-weather');
    }
}
