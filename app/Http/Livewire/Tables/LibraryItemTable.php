<?php

namespace App\Http\Livewire\Tables;

use App\Enums\LibraryItemType;
use App\Models\Library;
use App\Models\LibraryItem;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Spatie\LaravelOptions\Options;

class LibraryItemTable extends DataTableComponent
{
    public string $currentTab;
    public string $tableName = 'library_items';

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setAdditionalSelects(['id'])
            ->setDefaultSort('order_column', 'asc')
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
            TextFilter::make(__('By id'), 'id')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->where('library_items.id', '=', $value);
                      }),
            TextFilter::make(__('By lecturer'), 'lecturer_id')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->where('library_items.lecturer_id', '=', $value);
                      }),
            MultiSelectFilter::make('Tag')
                             ->options(
                                 Tag::query()
                                    ->where('type', 'library_item')
                                    ->get()
                                    ->pluck('name', 'id')
                                    ->toArray()
                             )
                             ->filter(function (Builder $builder, array $values) {
                                 $builder->whereHas('tags', function (Builder $query) use ($values) {
                                     $query->whereIn('tags.id', $values);
                                 });
                             }),
            SelectFilter::make('Bibliothek')
                        ->options(
                            Library::query()
                                   ->where('is_public', true)
                                   ->get()
                                   ->prepend(new Library(['name' => '*']))
                                   ->pluck('name', 'name')
                                   ->toArray(),
                        )
                        ->filter(function (Builder $builder, string $value) {
                            if ($value === '*') {
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
            SelectFilter::make('Art')
                        ->options(
                            collect(
                                Options::forEnum(LibraryItemType::class)
                                       ->toArray()
                            )
                                ->mapWithKeys(fn($value, $key) => [$value['value'] => $value['label']])
                                ->prepend('*', '')
                                ->toArray()
                        )
                        ->filter(function (Builder $builder, string $value) {
                            if ($value === '*') {
                                return;
                            }
                            $builder->where('library_items.type', $value);
                        }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('Image'))
                  ->label(
                      fn($row, Column $column) => view('columns.library_items.image')->withRow($row)
                  )
                  ->collapseOnMobile(),
            Column::make(__('Creator'), "lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.lecturer')->withRow($row)
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Art", "type")
                  ->format(
                      function ($value, $row, Column $column) {
                          return '<span class="whitespace-nowrap inline-flex items-center rounded-full bg-amber-400 px-2.5 py-0.5 text-base font-medium text-gray-900"><i class="mr-2 fa fa-thin fa-'
                                 .LibraryItemType::icons()[$value]
                                 .'"></i>'
                                 .LibraryItemType::labels()[$value]
                                 .'</span>';
                      })
                  ->html()
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Tags")
                  ->label(
                      fn($row, Column $column) => view('columns.library_items.tags')->withRow($row)
                  )
                  ->collapseOnMobile(),
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.library_items.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        $shouldBePublic = request()
                              ->route()
                              ->getName() !== 'library.table.lecturer';

        return LibraryItem::query()
                          ->with([
                              'lecturer',
                              'tags',
                          ])
                          ->whereHas('libraries', fn($query) => $query->where('libraries.is_public', $shouldBePublic))
                          ->when($this->currentTab !== '*', fn($query) => $query->whereHas('libraries',
                              fn($query) => $query->where('libraries.name', $this->currentTab)))
                          ->withCount([
                              'lecturer',
                          ])
                          ->currentStatus('published');
    }
}
