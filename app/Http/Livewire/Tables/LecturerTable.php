<?php

namespace App\Http\Livewire\Tables;

use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class LecturerTable extends DataTableComponent
{
    public string $country;

    public string $tableName = 'lecturers';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id'])
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
             ->setPerPage(10)
             ->setConfigurableAreas([
                 'toolbar-left-end' => [
                     'columns.lectures.areas.toolbar-left-end', [
                         'country' => $this->country,
                     ],
                 ],
             ]);
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('Bild')
                       ->location(
                           fn ($row) => $row->getFirstMediaUrl('avatar', 'thumb')
                       )
                       ->attributes(fn ($row) => [
                           'class' => 'rounded h-16 w-16',
                           'alt' => $row->name.' Avatar',
                       ])
                       ->collapseOnMobile(),
            Column::make('Name', 'name')
                  ->searchable(fn ($query, $term) => $query->where('name', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            BooleanColumn::make('Aktiv', 'active')
                         ->sortable()
                         ->collapseOnMobile(),
            Column::make('Kurse')
                  ->label(
                      fn ($row, Column $column) => $row->courses_count
                  )
                  ->collapseOnMobile(),
            Column::make('Inhalte')
                  ->label(
                      fn ($row, Column $column) => $row->library_items_count
                  )
                  ->collapseOnMobile(),
            Column::make('')
                  ->label(
                      fn ($row, Column $column) => view('columns.lectures.action')
                          ->withRow($row)
                          ->withCountry($this->country)
                  ),

        ];
    }

    public function builder(): Builder
    {
        return Lecturer::query()
                       ->withCount([
                           'courses',
                           'coursesEvents',
                           'libraryItems' => fn($query) => $query->where('news', false)
                       ]);
    }

    public function lecturerSearch($id, $event = true)
    {
        $lecturer = Lecturer::query()
                            ->find($id);

        if ($event) {
            return to_route('school.table.event', [
                '#table',
                'country' => $this->country,
                'course_events' => [
                    'filters' => [
                        'dozent' => $lecturer->id,
                    ],
                ],
            ]);
        } else {
            return to_route('library.table.libraryItems', [
                '#table',
                'country' => $this->country,
                'filters' => [
                    'lecturer_id' => $lecturer->id,
                ],
            ]);
        }
    }
}
