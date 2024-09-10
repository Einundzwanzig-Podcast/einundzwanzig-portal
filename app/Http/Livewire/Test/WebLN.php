<?php

namespace App\Http\Livewire\Test;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WebLN extends Component
{
    public function logThis($text)
    {
        Log::info('WEBLN: ' . $text);
    }

    public function render()
    {
        return view('livewire.test.web-l-n')->layout('layouts.test');
    }
}
