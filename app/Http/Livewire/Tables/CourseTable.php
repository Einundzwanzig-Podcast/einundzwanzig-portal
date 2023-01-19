<?php

namespace App\Http\Livewire\Tables;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class CourseTable extends DataTableComponent
{
    public string $country;
    public string $tableName = 'courses';

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
             ->setPerPage(10);
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Tag')
                             ->options(
                                 Tag::query()
                                    ->withType('course')
                                    ->get()
                                    ->mapWithKeys(fn($item, $key) => [$item->name => $item->name])
                                    ->toArray()
                             )
                             ->filter(function (Builder $builder, array $values) {
                                 $builder->withAnyTags($values, 'course');
                             }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Dozent', "lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.lecturer')->withRow($row)
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Name", "name")
                  ->searchable(fn(Builder $query, string $term) => $query->where('name', 'ilike', '%'.$term.'%'))
                  ->sortable(),
            Column::make("Tags")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.tags')->withRow($row)
                  )
                  ->collapseOnMobile(),
            Column::make("Termine")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->course_events_count.'</strong>'
                  )
                  ->html()
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Erstellt am", "created_at")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.courses.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return Course::query()
                     ->with([
                         'lecturer',
                         'tags',
                     ])
                     ->withCount([
                         'courseEvents',
                     ])
                     ->whereHas('courseEvents.venue.city.country',
                         fn($query) => $query->where('countries.code', $this->country))
                     ->orderByDesc('course_events_count')
                     ->orderBy('courses.id');
    }

    public function courseSearch($id)
    {
        return to_route('school.table.event', [
            '#table',
            'country'       => $this->country,
            'course_events' => [
                'filters' => [
                    'course_id' => $id,
                ],
            ]
        ]);
    }
}
