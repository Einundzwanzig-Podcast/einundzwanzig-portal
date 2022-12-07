<?php

namespace App\Http\Livewire\Tables;

use App\Models\BookCase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BookCaseTable extends DataTableComponent
{
    public bool $viewingModal = false;
    public $currentModal;
    public array $orangepill = [
        'amount' => 1,
        'date' => null,
    ];
    protected $model = BookCase::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id', 'homepage'])
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
            Column::make("Name", "title")
                  ->sortable()
                  ->searchable(),
            Column::make("Adresse", "address")
                  ->sortable()
                  ->searchable(),
            Column::make("Link")
                  ->label(
                      fn(
                          $row,
                          Column $column
                      ) => $row->homepage ? '<a target="_blank" class="underline text-amber-500" href="'.$this->url_to_absolute($row->homepage).'">Link</a>' : null
                  )
                  ->html(),
            Column::make('Orange-Pilled', 'orange_pilled')
                  ->label(fn($row, Column $column) => view('columns.book_cases.oranged-pilled')->withRow($row)),
        ];
    }

    private function url_to_absolute($url)
    {
        // Determine request protocol
        $request_protocol = $request_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http');
        // If dealing with a Protocol Relative URL
        if (stripos($url, '//') === 0) {
            return $url;
        }
        // If dealing with a Root-Relative URL
        if (stripos($url, '/') === 0) {
            return $request_protocol.'://'.$_SERVER['HTTP_HOST'].$url;
        }
        // If dealing with an Absolute URL, just return it as-is
        if (stripos($url, 'http') === 0) {
            return $url;
        }
        // If dealing with a relative URL,
        // and attempt to handle double dot notation ".."
        do {
            $url = preg_replace('/[^\/]+\/\.\.\//', '', $url, 1, $count);
        } while ($count);
        // Return the absolute version of a Relative URL
        return $request_protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$url;
    }

    public function viewHistoryModal($modelId): void
    {
        $this->viewingModal = true;
        $this->currentModal = BookCase::findOrFail($modelId);
    }

    public function resetModal(): void
    {
        $this->reset('viewingModal', 'currentModal');
    }

    public function customView(): string
    {
        return 'modals.book_cases.orange_pill';
    }
}
