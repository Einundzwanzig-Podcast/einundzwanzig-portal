<?php

namespace App\Http\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ProjectProposal;

class ProjectProposalTable extends DataTableComponent
{
    public ?string $country = null;

    public string $tableName = 'project_proposals';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['project_proposals.id', 'project_proposals.created_by', 'project_proposals.slug'])
             ->setThAttributes(function (Column $column) {
                 return [
                     'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400',
                     'default' => false,
                 ];
             })
             ->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
                 return [
                     'class' => 'px-6 py-4 text-sm font-medium dark:text-white',
                     'default' => false,
                 ];
             })
             ->setColumnSelectStatus(false)
             ->setPerPage(10)
             ->setConfigurableAreas([
                 'toolbar-left-end' => [
                     'columns.project_proposals.areas.toolbar-left-end', [
                         'country' => $this->country,
                     ],
                 ],
             ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make(__('Intended support in sats'), "support_in_sats")
                ->format(
                    fn ($value, $row, Column $column) => number_format($value, 0, ',', '.')
                )
                ->sortable(),
            Column::make('')
                  ->label(
                      fn ($row, Column $column) => view('columns.project_proposals.action')->withRow($row)->withCountry($this->country)
                  ),
        ];
    }

    public function builder(): Builder
    {
        return ProjectProposal::query();
    }
}
