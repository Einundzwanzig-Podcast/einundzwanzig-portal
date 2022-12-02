<?php

namespace App\Http\Livewire\Tables;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EventTable extends DataTableComponent
{
    public string $country;

    protected $model = Event::class;

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
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
}
