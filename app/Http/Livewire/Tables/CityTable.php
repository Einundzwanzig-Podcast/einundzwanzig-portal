<?php

namespace App\Http\Livewire\Tables;

use App\Models\BookCase;
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
             ->setThAttributes(function (Column $column) {
                 return [
                     'class'   => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400',
                     'default' => false,
                 ];
             })
             ->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
                 return [
                     'class'   => 'px-6 py-4 text-sm font-medium dark:text-white',
                     'default' => false,
                 ];
             })
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
                  )
                  ->collapseOnMobile(),
            Column::make('Termine')
                  ->label(
                      fn($row, Column $column) => $row->events_count
                  )
                  ->collapseOnMobile(),
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
        return to_route('search.event', [
            '#table',
            'country' => $this->country,
            'table'   => [
                'filters' => [
                    'stadt' => $query->pluck('name')
                                     ->push($city->name)
                                     ->implode(',')
                ],
            ]
        ]);
    }

    public function proximitySearchForBookCases($id)
    {
        $city = City::query()
                    ->find($id);
        $query = BookCase::radius($city->latitude, $city->longitude, 5);
        return to_route('search.bookcases', [
            '#table',
            'country' => $this->country,
            'table'   => [
                'filters' => [
                    'byids' => $query->pluck('id')
                                     ->implode(',')
                ],
            ]
        ]);
    }
}
