<?php

namespace App\Http\Livewire\Tables;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use WireUi\Traits\Actions;

class CityTable extends DataTableComponent
{
    use Actions;

    public string $country;

    protected $model = City::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id'])
             ->setColumnSelectStatus(false)
             ->setPerPage(50);
    }

    public function columns(): array
    {
        return [
            Column::make("Stadt Name", "name")
                  ->sortable()
                  ->searchable(),
            Column::make('Veranstaltungs-Orte')
                  ->label(
                      fn($row, Column $column) => $row->venues_count
                  ),
            Column::make('Termine')
                  ->label(
                      fn($row, Column $column) => $row->events_count
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
                   ->withCount([
                       'venues',
                       'events',
                   ])
                   ->whereHas('country', fn($query) => $query->where('code', $this->country));
    }

    public function proximitySearch($id)
    {
        $city = City::query()
                    ->find($id);
        $query = City::radius($city->latitude, $city->longitude, 100)
                     ->where('id', '!=', $id);
        $this->notification()
             ->success('Proximity Search', 'Found '.$query->count().' cities. '.$query->pluck('name')
                                                                                      ->implode(', '));
    }
}
