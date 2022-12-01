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
    protected $model = Lecturer::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('')
                       ->location(
                           fn($row) => 'https://avatars.dicebear.com/api/male/'.fake()->name().'.svg?background=%23000'
                       )
                       ->attributes(fn($row) => [
                           'class' => 'rounded-full h-16 w-16',
                           'alt'   => $row->name.' Avatar',
                       ]),
            Column::make("Name", "name")
                  ->sortable(),
            BooleanColumn::make("Aktiv", "active")
                         ->sortable(),
            Column::make('Kurse')
                  ->label(
                      fn($row, Column $column) => $row->courses_count
                  ),
            Column::make('')
                  ->label(
                      fn($row, Column $column) => view('columns.lectures.action')->withRow($row)
                  ),

        ];
    }

    public function builder(): Builder
    {
        return Lecturer::query()
                       ->withCount([
                           'courses',
                       ]);
    }
}
