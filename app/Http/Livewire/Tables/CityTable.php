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

    public bool $manage = false;

    public string $tableName = 'cities';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['cities.id', 'cities.created_by'])
             ->setThAttributes(function (Column $column) {
                 return [
                     'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400',
                     'default' => false,
                 ];
             })
             ->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
                 return [
                     'class' => 'px-6 py-4 text-sm font-medium dark:text-white',
                     'default' => false,
                 ];
             })
             ->setColumnSelectStatus(false)
             ->setPerPage(10)
             ->setConfigurableAreas([
                 'toolbar-left-end' => [
                     'columns.cities.areas.toolbar-left-end', [
                         'country' => $this->country,
                     ],
                 ],
             ]);
    }

    public function columns(): array
    {
        $columns = collect([
            Column::make('Stadt Name', 'name')
                  ->sortable()
                  ->searchable(fn ($builder, $term) => $builder->where('cities.name', 'ilike', '%'.$term.'%')),
        ]);
        if ($this->type === 'school') {
            $columns = $columns->merge([
                Column::make('Veranstaltungs-Orte')
                      ->label(
                          fn ($row, Column $column) => $row->venues_count
                      )
                      ->collapseOnMobile(),
                Column::make('Termine')
                      ->label(
                          fn ($row, Column $column) => $row->course_events_count
                      )
                      ->collapseOnMobile(),
            ]);
        }

        return $columns->merge([
            Column::make('')
                  ->label(
                      fn ($row, Column $column) => view('columns.cities.action')
                          ->withRow($row)
                          ->withType($this->type)
                          ->withManage($this->manage)
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
                   ->whereHas('country', fn ($query) => $query->where('code', $this->country))
                   ->orderByDesc('course_events_count')
                   ->orderBy('cities.id');
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
            'course_events' => [
                'filters' => [
                    'stadt' => $query->pluck('name')
                                     ->push($city->name)
                                     ->implode(','),
                ],
            ],
        ]);
    }

    public function proximitySearchForBookCases($id)
    {
        $city = City::query()
                    ->find($id);
        $query = BookCase::active()->radius($city->latitude, $city->longitude, 25);
        $ids = $query->pluck('id');
        if ($ids->isEmpty()) {
            $this->notification()
                 ->error(__('No bookcases found in the radius of 5km'));

            return;
        }

        return to_route('bookCases.table.bookcases', [
            '#table',
            'country' => $this->country,
            'bookcases' => [
                'filters' => [
                    'byids' => $ids->implode(','),
                ],
            ],
        ]);
    }
}
