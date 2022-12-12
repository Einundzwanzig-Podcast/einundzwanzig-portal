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
    protected $model = CourseEvent::class;

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setDefaultSort('from', 'asc')
            ->setAdditionalSelects([
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
            ->setPerPage(50);
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Stadt')
                      ->config([
                          'placeholder' => __('Suche Stadt'),
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
            TextFilter::make('Veranstaltungs-Ort', 'venue')
                      ->config([
                          'placeholder' => __('Suche Veranstaltungs-Ort'),
                      ])
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('venue',
                              fn($query) => $query->where('venues.name', 'ilike', "%$value%"));
                      }),
            TextFilter::make('Kurs')
                      ->config([
                          'placeholder' => __('Suche Kurs'),
                      ])
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('course',
                              fn($query) => $query->where('courses.name', 'ilike', "%$value%"));
                      }),
            TextFilter::make('Kurs by ID', 'course_id')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereHas('course',
                              fn($query) => $query->where('courses.id', '=', $value));
                      }),
            MultiSelectFilter::make('Art')
                             ->options(
                                 Category::query()
                                         ->pluck('name', 'id')
                                         ->toArray()
                             )
                             ->filter(function (Builder $builder, array $values) {
                                 $builder->whereHas('course.categories',
                                     fn($query) => $query->whereIn('categories.id', $values));
                             }),
            SelectFilter::make('Dozent')
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
            Column::make("Stadt", "venue.city.name")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Veranstaltungs-Ort", "venue.name")
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make('Dozent', "course.lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.events.lecturer')->withRow($row)
                  )
                  ->sortable()
                  ->collapseOnMobile(),
            Column::make("Kurs", "course.name")
                  ->sortable(),
            Column::make("Art")
                  ->label(
                      fn($row, Column $column) => view('columns.events.categories')->withRow($row)
                  )
                  ->collapseOnMobile(),
            Column::make("Von", "from")
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable(),
            Column::make("Bis", "to")
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
            Column::make('Aktion')
                  ->label(
                      fn($row, Column $column) => view('columns.events.action')->withRow($row)
                  )
                  ->collapseOnMobile(),
        ];
    }

    public function builder(): Builder
    {
        return CourseEvent::query()
                          ->withCount([
                        'registrations',
                    ])
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
