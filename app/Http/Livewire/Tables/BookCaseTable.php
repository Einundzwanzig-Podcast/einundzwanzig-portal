<?php

namespace App\Http\Livewire\Tables;

use App\Models\BookCase;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use WireUi\Traits\Actions;

class BookCaseTable extends DataTableComponent
{
    use Actions;

    public string $country;

    public string $tableName = 'bookcases';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id', 'homepage'])
             ->setThAttributes(function (Column $column) {
                 return [
                     'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400',
                     'default' => false,
                 ];
             })
             ->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
                 return [
                     'class' => 'px-6 py-4 text-sm font-medium dark:text-white',
                     'default' => false,
                 ];
             })
             ->setColumnSelectStatus(false)
             ->setPerPage(10);
    }

    public function filters(): array
    {
        return [
            TextFilter::make('By IDs', 'byids')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('id', str($value)->explode(','));
                      }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'title')
                  ->sortable()
                  ->searchable(
                      function (Builder $query, $searchTerm) {
                          $query->where('title', 'ilike', '%'.$searchTerm.'%');
                      }
                  ),
            Column::make('Adresse', 'address')
                  ->sortable()
                  ->searchable(),
            Column::make('Bitcoin-Bücher')
                  ->label(
                      fn (
                          $row,
                          Column $column
                      ) => $row->orangePills->sum('amount')
                  )
                  ->collapseOnMobile(),
            Column::make('Letzter Input')
                  ->label(
                      fn (
                          $row,
                          Column $column
                      ) => $row->orangePills()
                               ->latest()
                               ->first()?->date->asDate()
                  )
                  ->collapseOnMobile(),
            Column::make('Link')
                  ->label(
                      fn (
                          $row,
                          Column $column
                      ) => $row->homepage ? '<a target="_blank" class="underline text-amber-500" href="'.$this->url_to_absolute($row->homepage).'">Link</a>' : null
                  )
                  ->html()
                  ->collapseOnMobile(),
            Column::make('Orange-Pilled', 'orange_pilled')
                  ->label(fn ($row, Column $column) => view('columns.book_cases.oranged-pilled')
                      ->withRow($row)
                      ->withCountry($this->country))
                  ->collapseOnMobile(),
        ];
    }

    private function url_to_absolute($url)
    {
        if (str($url)->contains('http')) {
            return $url;
        }
        if (! str($url)->contains('http')) {
            return str($url)->prepend('https://');
        }
    }

    public function builder(): Builder
    {
        return BookCase::query()
                       ->active()
                       ->with([
                           'orangePills',
                       ])
                       ->withCount([
                           'orangePills',
                       ])
                       ->orderByDesc('orange_pills_count')
                       ->orderBy('book_cases.id');
    }
}
