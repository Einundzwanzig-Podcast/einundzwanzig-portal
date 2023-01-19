<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class MeetupTable extends DataTableComponent
{
    public ?string $country = null;
    public string $tableName = 'meetups';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id'])
             ->setDefaultSort('users_count', 'desc')
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
                  ->searchable(fn($builder, $term) => $builder->where('meetups.name', 'ilike', '%'.$term.'%')),
            Column::make(__('Plebs'))
                  ->label(fn($row, Column $column) => $row->users_count)
                  ->collapseOnMobile(),
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
                     ->when($this->country, fn($query, $country) => $query->whereHas('city.country',
                         fn($query) => $query->where('code', $this->country)))
                     ->with([
                         'users',
                         'city.country',
                         'meetupEvents',
                     ]);
//                     ->withCount([
//                         'users',
//                         'meetupEvents' => fn($query) => $query->where('start', '>=', now()),
//                     ])
//->when($this->country, fn($query) => $query->orderBy('meetup_events_count', 'desc'));
    }

    public function meetupEventSearch($id)
    {
        $meetup = Meetup::with(['city.country'])
                        ->find($id);

        return to_route('meetup.table.meetupEvent', [
            'country' => $this->country ?? $meetup->city->country->code,
            'table'   => [
                'filters' => ['bymeetupid' => $id],
            ]
        ]);
    }
}
