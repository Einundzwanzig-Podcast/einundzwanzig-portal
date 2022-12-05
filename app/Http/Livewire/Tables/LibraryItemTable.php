<?php

namespace App\Http\Livewire\Tables;

use App\Models\LibraryItem;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class LibraryItemTable extends DataTableComponent
{
    protected $model = LibraryItem::class;

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setDefaultSort('order_column', 'asc');
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('Bild')
                       ->location(
                           fn($row) => $row->getFirstMediaUrl('main', 'thumb')
                       )
                       ->attributes(fn($row) => [
                           'class' => 'rounded h-16',
                           'alt'   => $row->name.' Avatar',
                       ])
                       ->collapseOnMobile(),
            Column::make('Dozent', "lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.lecturer')->withRow($row)
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Art", "type")
                  ->sortable(),
            Column::make("Sprache", "language_code")
                  ->sortable(),

            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.library_items.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return LibraryItem::query()
                          ->withCount([
                              'lecturer',
                          ]);
    }
}
