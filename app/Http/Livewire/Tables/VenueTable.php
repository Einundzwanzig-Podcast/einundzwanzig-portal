<?php

namespace App\Http\Livewire\Tables;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class VenueTable extends DataTableComponent
{
    public string $country;

    protected $model = Venue::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("City id", "city_id")
                  ->sortable(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Street", "street")
                  ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Venue::query()
                    ->whereHas('city.country', fn($query) => $query->where('code', $this->country));
    }
}
