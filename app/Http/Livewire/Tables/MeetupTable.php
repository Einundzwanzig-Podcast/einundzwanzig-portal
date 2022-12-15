<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetups.name')->withRow($row)
                  )
                  ->sortable(),
            Column::make(__('Link'), 'link')
                  ->format(
                      fn($value, $row, Column $column) => view('columns.meetups.link')->withRow($row)
                  )
                  ->sortable(),
            Column::make(__('Actions'),)
                  ->label(
                      fn($row, Column $column) => view('columns.meetups.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return Meetup::query()
                     ->whereHas('city.country', fn($query) => $query->where('code', $this->country))
                     ->withCount([
                         'meetupEvents',
                     ])
                     ->orderBy('meetup_events_count', 'desc');
    }

    public function meetupEventSearch($id)
    {
        return to_route('meetup.table.meetupEvent', [
            'country' => $this->country,
            'table'   => [
                'filters' => ['id' => $id],
            ]
        ]);
    }
}
