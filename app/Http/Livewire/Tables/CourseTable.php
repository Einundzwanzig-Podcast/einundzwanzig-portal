<?php

namespace App\Http\Livewire\Tables;

use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CourseTable extends DataTableComponent
{
    public string $country;

    protected $model = Course::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setColumnSelectStatus(false)
             ->setPerPage(50);
    }

    public function columns(): array
    {
        return [
            Column::make('Dozent', "lecturer.name")
                  ->label(
                      fn($row, Column $column) => view('columns.courses.lecturer')->withRow($row)
                  )
                  ->sortable(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Termine")
                  ->label(
                      fn($row, Column $column) => '<strong>'.$row->events_count.'</strong>'
                  )
                  ->html()
                  ->sortable(),
            Column::make("Erstellt am", "created_at")
                  ->sortable(),
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
}
