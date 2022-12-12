<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meetup;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MeetupTable extends DataTableComponent
{
    public string $country;

    protected $model = Meetup::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')
                  ->sortable(),
            Column::make(__('Link'), 'link')
                  ->sortable(),
        ];
    }
}
