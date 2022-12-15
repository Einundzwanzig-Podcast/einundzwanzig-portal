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

    protected $model = MeetupEvent::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setDefaultSort('start', 'asc')
             ->setAdditionalSelects(['meetup_events.meetup_id'])
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

    public function filters(): array
    {
        return [
            TextFilter::make('Meetup-Event by ID', 'byid')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('meetup_events.meetup_id', str($value)->explode(','));
                      }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('Meetup'), 'meetup.name')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetup_events.name')->withRow($row)
                  )
                  ->searchable(fn($builder, $term) => $builder->where('meetups.name', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            Column::make(__('Location'), 'location')
                  ->searchable(fn($builder, $term) => $builder->where('location', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            Column::make(__('Start'), 'start')
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable(),
            Column::make(__('Link'), 'link')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetup_events.link')->withRow($row)
                  )
                  ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return MeetupEvent::query()
                          ->whereHas('meetup.city.country', fn($query) => $query->where('code', $this->country))
                          ->with([
                              'meetup',
                          ]);
    }
}
