<?php

namespace App\Http\Livewire\Tables;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class EventTable extends DataTableComponent
{
    public string $country;
    public bool $viewingModal = false;
    public $currentModal;
    protected $model = Event::class;

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
                                          foreach (str($value)->explode(',') as $item) {
                                              $query->orWhere('cities.name', 'ilike', "%$item%");
                                          }
                                      });
                          } else {
                              $builder->whereHas('venue.city',
                                  fn($query) => $query->where('cities.name', 'ilike', "%$value%"));
                          }
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
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Stadt", "venue.city.name")
                  ->sortable(),
            Column::make("Veranstaltungs-Ort", "venue.name")
                  ->sortable(),
            Column::make('Dozent', "course.lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.events.lecturer')->withRow($row)
                  )
                  ->sortable(),
            Column::make("Kurs", "course.name")
                  ->sortable(),
            Column::make("Art")
                  ->label(
                      fn($row, Column $column) => view('columns.events.categories')->withRow($row)
                  ),
            Column::make("Von", "from")
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable(),
            Column::make("Bis", "to")
                  ->format(
                      fn($value, $row, Column $column) => $value->asDateTime()
                  )
                  ->sortable(),
            /*Column::make("Teilnehmer")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->registrations->count().'</strong>'
                  )
                  ->html()
                  ->sortable(),*/
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.events.action')->withRow($row)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return Event::query()
                    ->withCount([
                        'registrations',
                    ])
                    ->whereHas('venue.city.country',
                        fn($query) => $query->where('countries.code', $this->country));
    }

    public function viewHistoryModal($modelId): void
    {
        $this->viewingModal = true;
        $this->currentModal = Event::findOrFail($modelId);
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
