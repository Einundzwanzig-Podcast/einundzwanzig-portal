<?php

namespace App\Http\Livewire\Helper;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class FollowTheRabbit extends Component
{
    public function render()
    {
        return view('livewire.helper.follow-the-rabbit')->layout('layouts.guest', [
            'SEOData' => new SEOData(
                title: __('Bitcoin - Rabbit Hole'),
                description: __('This is a great overview of the Bitcoin rabbit hole with entrances to areas Bitcoin encompasses. Each topic has its own rabbit hole, visualized through infographics in a simple and understandable way, with QR codes leading to explanatory videos and articles. Play fun on your journey of discovery!'),
                image: asset('img/kaninchenbau.png')
            ),
        ]);
    }
}
