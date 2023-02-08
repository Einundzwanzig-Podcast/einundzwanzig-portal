<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use Livewire\Component;

class Heatmap extends Component
{
    public string $country;

    public function render()
    {
        $data = BookCase::query()
                        //->whereHas('orangePills')
                        ->get()->map(fn($bookCase) => [
            'lat' => $bookCase->latitude,
            'lng' => $bookCase->longitude,
        ]);

        return view('livewire.book-case.heatmap', [
            'heatmap_data' => $data->toArray(),
        ]);
    }
}
