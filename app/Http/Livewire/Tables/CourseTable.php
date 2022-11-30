<?php

namespace App\Http\Livewire\Tables;

use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CourseTable extends DataTableComponent
{
    protected $model = Course::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                  ->sortable(),
            Column::make("Lecturer id", "lecturer_id")
                  ->sortable(),
            Column::make("Name", "name")
                  ->sortable(),
            Column::make("Created at", "created_at")
                  ->sortable(),
            Column::make("Updated at", "updated_at")
                  ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Course::query()
                     ->whereHas('country', fn($query) => $query->where('code', $this->country));
    }
}
