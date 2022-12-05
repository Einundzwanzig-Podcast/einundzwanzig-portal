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

    protected $model = Course::class;

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

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Tag')
                             ->options(
                                 Tag::query()
                                    ->get()
                                    ->mapWithKeys(fn($item, $key) => [$item->name => $item->name])
                                    ->toArray()
                             )
                             ->filter(function (Builder $builder, array $values) {
                                 $builder->withAnyTags($values, 'search');
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
                  ->sortable(),
            Column::make("Tags")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.tags')->withRow($row)
                  ),
            Column::make("Termine")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->events_count.'</strong>'
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
                     ->withCount([
                         'events',
                     ])
                     ->whereHas('events.venue.city.country',
                         fn($query) => $query->where('countries.code', $this->country));
    }

    public function courseSearch($id)
    {
        return to_route('search.event', [
            '#table',
            'country' => $this->country,
            'table'   => [
                'filters' => [
                    'course_id' => $id,
                ],
            ]
        ]);
    }
}
