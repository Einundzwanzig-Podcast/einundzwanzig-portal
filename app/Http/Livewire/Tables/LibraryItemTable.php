<?php

namespace App\Http\Livewire\Tables;

use App\Models\Library;
use App\Models\LibraryItem;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class LibraryItemTable extends DataTableComponent
{
    public string $currentTab;
    protected $model = LibraryItem::class;

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setDefaultSort('order_column', 'asc');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Bibliothek')
                        ->options(
                            Library::query()
                                   ->get()
                                   ->prepend(new Library(['name' => 'Alle']))
                                   ->pluck('name', 'name')
                                   ->toArray(),
                        )
                        ->filter(function (Builder $builder, string $value) {
                            if ($value === 'Alle') {
                                return;
                            }
                            if (str($value)->contains(',')) {
                                $builder
                                    ->whereHas('libraries',
                                        function ($query) use ($value) {
                                            $query->whereIn('libraries.name', str($value)->explode(','));
                                        });
                            } else {
                                $builder->whereHas('libraries',
                                    fn($query) => $query->where('libraries.name', 'ilike', "%$value%"));
                            }
                        }),
        ];
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
                          ->when($this->currentTab !== 'Alle', fn($query) => $query->whereHas('libraries',
                              fn($query) => $query->where('libraries.name', $this->currentTab)))
                          ->withCount([
                              'lecturer',
                          ]);
    }
}
