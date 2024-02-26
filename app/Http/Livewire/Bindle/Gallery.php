<?php

namespace App\Http\Livewire\Bindle;

use App\Models\LibraryItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Gallery extends Component
{
    public Collection $bindles;
    public string $search = '';

    public function mount()
    {
        $this->bindles = LibraryItem::searchLibraryItems('bindle');
    }

    public function updatedSearch($value)
    {
        $this->bindles = LibraryItem::searchLibraryItems('bindle', $value);
    }

    public function deleteBindle($id)
    {
        LibraryItem::query()->find($id)?->delete();

        return to_route('bindles');
    }

    public function render()
    {
        return view('livewire.bindle.gallery')
            ->layout('layouts.app', [
                'SEOData' => new SEOData(
                    title: __('Bindle Gallery'),
                    description: __('Die berühmte Bindlesammlung von FiatTracker.'),
                    image: asset('img/fiat_tracker.jpg'),
                ),
            ]);
    }
}
