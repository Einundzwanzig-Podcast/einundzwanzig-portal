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
    public string $type;

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
             ->setPerPage(10);
    }

    public function columns(): array
    {
        $columns = collect([
            Column::make("Stadt Name", "name")
                  ->sortable()
                  ->searchable(),
        ]);
        if ($this->type === 'school') {
            $columns = $columns->merge([
                Column::make('Veranstaltungs-Orte')
                      ->label(
                          fn($row, Column $column) => $row->venues_count
                      )
                      ->collapseOnMobile(),
                Column::make('Termine')
                      ->label(
                          fn($row, Column $column) => $row->course_events_count
                      )
                      ->collapseOnMobile(),
            ]);
        }

        return $columns->merge([
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.cities.action')
                          ->withRow($row)
                          ->withType($this->type)
                  ),
        ])
                       ->toArray();
    }

    public function builder(): Builder
    {
        return City::query()
                   ->withCount([
                       'venues',
                       'courseEvents',
                   ])
                   ->whereHas('country', fn($query) => $query->where('code', $this->country));
    }

    public function proximitySearch($id)
    {
        $city = City::query()
                    ->find($id);
        $query = City::radius($city->latitude, $city->longitude, 100)
                     ->where('id', '!=', $id);
        return to_route('school.table.event', [
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
        $ids = $query->pluck('id');
        if ($ids->isEmpty()) {
            $this->notification()
                 ->error(__('No bookcases found in the radius of 5km'));
            return;
        }

        return to_route('bookCases.table.bookcases', [
            '#table',
            'table' => [
                'filters' => [
                    'byids' => $ids->implode(',')
                ],
            ]
        ]);
    }
}
