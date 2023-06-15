<?php

namespace App\Http\Livewire\Specials;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class BalticSeaCircle extends Component
{
    public function render()
    {
        return view('livewire.specials.baltic-sea-circle')
            ->layout('layouts.guest', [
                'SEOData' => new SEOData(
                    title: 'Baltic Sea Circle Rally Bitcoin Team 218',
                    description: 'Besucht das Bitcoin Team 218 von Daktari und Cercatrova zum Start der diesjährigen Baltic Sea Circle Rally',
                    image: asset('img/bsc/3.jpg'),
                ),
            ]);
    }
}
