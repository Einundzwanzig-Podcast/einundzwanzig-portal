<?php

namespace App\Http\Livewire\Tables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\MeetupEvent;

class MeetupEventTable extends DataTableComponent
{
    public string $country;

    protected $model = MeetupEvent::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Location'), 'location')
                ->sortable(),
            Column::make(__('Start'), 'start')
                ->sortable(),
            Column::make(__('Link'), 'link')
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
