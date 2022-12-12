<?php

namespace App\Http\Livewire\Tables;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class VenueTable extends DataTableComponent
{
    public string $country;

    protected $model = Venue::class;

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
             ->setPerPage(50);
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('Bild')
                       ->location(
                           fn($row) => $row->getFirstMediaUrl('images', 'thumb')
                       )
                       ->attributes(fn($row) => [
                           'class' => 'rounded h-16 w-16',
                           'alt'   => $row->name.' Avatar',
                       ])
                       ->collapseOnMobile(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Street", "street")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make('Termine')
                  ->label(
                      fn($row, Column $column) => $row->events_count
                  )
                  ->collapseOnMobile(),
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.venues.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return Venue::query()
                    ->withCount([
                        'events',
                    ])
                    ->whereHas('city.country', fn($query) => $query->where('code', $this->country));
    }

    public function venueSearch($id)
    {
        $venue = Venue::query()->find($id);

        return to_route('school.table.event', [
            '#table',
            'country' => $this->country,
            'table'   => [
                'filters' => [
                    'venue' => $venue->name,
                ],
            ]
        ]);
    }
}
