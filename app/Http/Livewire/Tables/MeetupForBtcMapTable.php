<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MeetupForBtcMapTable extends DataTableComponent
{
    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setAdditionalSelects([
                'osm_relation',
                'simplified_geojson',
                'population',
                'population_date',
                'city_id',
            ])
            ->setPerPageAccepted([
                100000,
            ])
            ->setPerPage(100000);
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                  ->sortable(),
            Column::make('Name', 'name')
                  ->sortable(),
            Column::make('City', 'city.name')
                  ->sortable(),
            Column::make('Country', 'city.country.name')
                  ->sortable(),
            Column::make('Actions')
                  ->label(fn ($row, Column $column) => view('columns.meetups.osm-actions', ['row' => $row])),
        ];
    }

    public function builder(): Builder
    {
        return Meetup::query()
                     ->with([
                         'city.country',
                     ])
                     ->orderBy('cities.population');
    }
}
