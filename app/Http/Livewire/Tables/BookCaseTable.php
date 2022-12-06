<?php

namespace App\Http\Livewire\Tables;

use App\Models\BookCase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class BookCaseTable extends DataTableComponent
{
    protected $model = BookCase::class;

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
            Column::make("Name", "title")
                  ->sortable()
                  ->searchable(),
            Column::make("Adresse", "address")
                  ->sortable()
                  ->searchable(),
            Column::make("Link")
                  ->label(
                      fn(
                          $row,
                          Column $column
                      ) => '<a class="underline text-amber-500" href="'.$row->homepage.'">Link</a>'
                  )
                  ->html(),
            BooleanColumn::make('Oranged-Pilled', 'deactivated')
                         ->sortable(),
        ];
    }
}
