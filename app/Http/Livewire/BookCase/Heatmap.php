<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Heatmap extends Component
{
    public string $country;

    public function render()
    {
        $data = BookCase::query()
                        ->active()
                        ->whereHas('orangePills')
                        ->get()
                        ->map(fn ($bookCase) => [
                            'lat' => $bookCase->latitude,
                            'lng' => $bookCase->longitude,
                        ]);

        return view('livewire.book-case.heatmap', [
            'heatmap_data' => $data->toArray(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Heatmap of Bookcases'),
                description: __('On this map you can see the success and spread of the Bitcoin books.'),
                image: asset('img/heatmap_bookcases.png'),
            ),
        ]);
    }
}
