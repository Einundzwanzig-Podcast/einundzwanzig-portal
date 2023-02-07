<?php

namespace App\Http\Livewire\Tables;

use App\Models\MeetupEvent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class MeetupEventTable extends DataTableComponent
{
    public string $country;

    public string $tableName = 'meetup_events';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['meetup_events.id', 'meetup_events.meetup_id'])
             ->setDefaultSort('start', 'asc')
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
             ->setPerPage(10)
             ->setConfigurableAreas([
                 'toolbar-left-end' => [
                     'columns.meetup_events.areas.toolbar-left-end', [
                         'country' => $this->country,
                     ],
                 ],
             ]);
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Meetup-Event by ID', 'bymeetupid')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('meetup_events.meetup_id', str($value)->explode(','));
                      }),
            TextFilter::make('Meetup-Event by ID', 'byid')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('meetup_events.id', str($value)->explode(','));
                      }),
        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('Meetup'), 'meetup.name')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetup_events.name')
                          ->withRow($row)
                          ->withCountry($this->country)
                  )
                  ->searchable(fn($builder, $term) => $builder->where('meetups.name', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            Column::make(__('Location'), 'location')
                  ->searchable(fn($builder, $term) => $builder->where('location', 'ilike', '%'.$term.'%'))
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make(__('Start'), 'start')
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make(__('Link'))
                  ->label(
                      fn($row, Column $column) => view('columns.meetup_events.link')
                          ->withRow($row)
                  ),
        ];

        $adminColumns = auth()->check() ? [
            Column::make(__('Actions'))
                  ->label(
                      fn($row, Column $column) => view('columns.meetup_events.manage')
                          ->withRow($row)
                  ),
        ] : [];

        return array_merge($columns, $adminColumns);
    }

    public function builder(): Builder
    {
        return MeetupEvent::query()
                          ->where('meetup_events.start', '>=', now())
                          ->whereHas('meetup.city.country', fn($query) => $query->where('code', $this->country))
                          ->with([
                              'meetup.city.country',
                          ]);
    }
}
