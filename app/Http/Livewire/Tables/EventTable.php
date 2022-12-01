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
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Stadt", "venue.city.name")
                  ->sortable(),
            Column::make("Veranstaltungs-Ort", "venue.name")
                  ->sortable(),
            Column::make("Dozent", "course.lecturer.name")
                  ->sortable(),
            Column::make("Kurs", "course.name")
                  ->sortable(),
            Column::make("Erstellt am", "created_at")
                  ->sortable(),
            Column::make("Zuletzt geändert", "updated_at")
                  ->sortable(),
            Column::make("Teilnehmer")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->registrations->count().'</strong>'
                  )
                  ->html()
                  ->sortable(),
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
