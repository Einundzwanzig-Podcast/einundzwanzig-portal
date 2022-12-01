<?php

namespace App\Http\Livewire\Tables;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CityTable extends DataTableComponent
{
    public string $country;

    protected $model = City::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Stadt Name", "name")
                  ->sortable()
                  ->searchable(),
            Column::make('Veranstaltungs-Orte')
                  ->label(
                      fn($row, Column $column) => random_int(0, 100)
                  ),
            Column::make('Kurse')
                  ->label(
                      fn($row, Column $column) => random_int(0, 100)
                  ),
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.cities.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return City::query()
                   ->whereHas('country', fn($query) => $query->where('code', $this->country));
    }
}
