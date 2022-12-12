<?php

namespace App\Http\Livewire\Tables;

use App\Models\BitcoinEvent;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BitcoinEventTable extends DataTableComponent
{
    public string $country;

    protected $model = BitcoinEvent::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['bitcoin_events.id'])
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
            Column::make(__('Venue'), 'venue.name'),
            Column::make(__('Title'), 'title')
                  ->sortable(),
            Column::make(__('Link'), 'link')
                  ->sortable(),
        ];
    }
}
