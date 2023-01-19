<?php

namespace App\Http\Livewire\Tables;

use App\Models\Category;
use App\Models\CourseEvent;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class EventTable extends DataTableComponent
{
    public string $country;
    public bool $viewingModal = false;
    public $currentModal;
    public string $tableName = 'events';

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setDefaultSort('from', 'asc')
            ->setAdditionalSelects([
                'course_events.id',
                'course_id',
                'venue_id',
            ])
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
            TextFilter::make('Event by ID', 'byid')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('course_events.id', str($value)->explode(','));
                      }),
            TextFilter::make(__('City'))
                      ->config([
                          'placeholder' => __('Search City'),
                      ])
                      ->filter(function (Builder $builder, string $value) {
                          if (str($value)->contains(',')) {
                              $builder
                                  ->whereHas('venue.city',
                                      function ($query) use ($value) {
                                          $query->whereIn('cities.name', str($value)->explode(','));
                                      });
                          } else {
                              $builder->whereHas('venue.city',
                                  fn($query) => $query->where('cities.name', 'ilike', "%$value%"));
                          }
                      }),
            TextFilter::make(__('Venue'), 'venue')
                      ->config([
                          'placeholder' => __('Search Venue'),
                      ])
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('venue',
                              fn($query) => $query->where('venues.name', 'ilike', "%$value%"));
                      }),
            TextFilter::make(__('Course'))
                      ->config([
                          'placeholder' => __('Search Course'),
                      ])
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('course',
                              fn($query) => $query->where('courses.name', 'ilike', "%$value%"));
                      }),
            TextFilter::make('Course by ID', 'course_id')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('course',
                              fn($query) => $query->where('courses.id', '=', $value));
                      }),
            MultiSelectFilter::make(__('Type'))
                             ->options(
                                 Category::query()
                                         ->pluck('name', 'id')
                                         ->toArray()
                             )
                             ->filter(function (Builder $builder, array $values) {
                                 $builder->whereHas('course.categories',
                                     fn($query) => $query->whereIn('categories.id', $values));
                             }),
            SelectFilter::make(__('Lecturer'))
                        ->options(
                            Lecturer::query()
                                    ->pluck('name', 'id')
                                    ->toArray()
                        )
                        ->filter(function (Builder $builder, string $value) {
                            $builder->whereHas('course.lecturer',
                                fn($query) => $query->where('lecturers.id', $value));
                        }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(_('City'), "venue.city.name")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make(__('Venue'), "venue.name")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make(__('Lecturer'), "course.lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.events.lecturer')->withRow($row)
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make(__('Course'), "course.name")
                  ->sortable(),
            Column::make(__('Type'))
                  ->label(
                      fn($row, Column $column) => view('columns.events.categories')->withRow($row)
                  )
                  ->collapseOnMobile(),
            Column::make(__('From'), "from")
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable(),
            Column::make(__('To'), "to")
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            /*Column::make("Teilnehmer")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->registrations->count().'</strong>'
                  )
                  ->html()
                  ->sortable(),*/
            Column::make(__('Actions'))
                  ->label(
                      fn($row, Column $column) => view('columns.events.action')->withRow($row)
                  )
                  ->collapseOnMobile(),
        ];
    }

    public function builder(): Builder
    {
        return CourseEvent::query()
                          ->with([
                              'course.lecturer',
                              'course.categories',
                          ])
                          ->where('from', '>=', now())
                          ->whereHas('venue.city.country',
                              fn($query) => $query->where('countries.code', $this->country));
    }

    public function viewHistoryModal($modelId): void
    {
        $this->viewingModal = true;
        $this->currentModal = CourseEvent::findOrFail($modelId);
    }

    public function resetModal(): void
    {
        $this->reset('viewingModal', 'currentModal');
    }

    public function customView(): string
    {
        return 'modals.events.register';
    }
}
