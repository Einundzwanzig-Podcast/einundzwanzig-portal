<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class MeetupTable extends DataTableComponent
{
    public string $country;

    protected $model = Meetup::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
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
            TextFilter::make('Meetup by ID', 'byid')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('meetups.id', str($value)->explode(','));
                      }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetups.name')->withRow($row)
                  )
                  ->searchable(fn($builder, $term) => $builder->where('meetups.name', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            Column::make(__('Links'))
                  ->label(
                      fn($row, Column $column) => view('columns.meetups.action')
                          ->withRow($row)
                          ->withCountry($this->country)
                  )
                  ->collapseOnMobile(),
        ];
    }

    public function builder(): Builder
    {
        return Meetup::query()
                     ->whereHas('city.country', fn($query) => $query->where('code', $this->country))
                     ->withCount([
                         'meetupEvents' => fn($query) => $query->where('start', '>=', now()),
                     ])
                     ->orderBy('meetup_events_count', 'desc');
    }

    public function meetupEventSearch($id)
    {
        return to_route('meetup.table.meetupEvent', [
            'country' => $this->country,
            'table'   => [
                'filters' => ['bymeetupid' => $id],
            ]
        ]);
    }
}
