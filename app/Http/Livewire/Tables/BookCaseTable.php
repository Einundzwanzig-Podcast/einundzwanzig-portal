<?php

namespace App\Http\Livewire\Tables;

use App\Models\BookCase;
use App\Models\OrangePill;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithFileUploads;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use WireUi\Traits\Actions;

class BookCaseTable extends DataTableComponent
{
    use WithFileUploads;
    use Actions;

    public string $country;

    public $photo;

    public bool $viewingModal = false;
    public $currentModal;
    public array $orangepill = [
        'amount'  => 1,
        'date'    => null,
        'comment' => '',
    ];
    protected $model = BookCase::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setAdditionalSelects(['id', 'homepage'])
             ->setDefaultSort('orange_pills_count', 'desc')
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
             ->setPerPage(10);
    }


    public function filters(): array
    {
        return [
            TextFilter::make('By IDs', 'byids')
                      ->hiddenFromMenus()
                      ->filter(function (Builder $builder, string $value) {
                          $builder->whereIn('id', str($value)->explode(','));
                      }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "title")
                  ->sortable()
                  ->searchable(
                      function (Builder $query, $searchTerm) {
                          $query->where('title', 'ilike', '%'.$searchTerm.'%');
                      }
                  ),
            Column::make("Adresse", "address")
                  ->sortable()
                  ->searchable(),
            Column::make("Bitcoin-Bücher")
                  ->label(
                      fn(
                          $row,
                          Column $column
                      ) => $row->orangePills->sum('amount')
                  ),
            Column::make("Letzter Input")
                  ->label(
                      fn(
                          $row,
                          Column $column
                      ) => $row->orangePills()
                               ->latest()
                               ->first()?->date->asDate()
                  ),
            Column::make("Link")
                  ->label(
                      fn(
                          $row,
                          Column $column
                      ) => $row->homepage ? '<a target="_blank" class="underline text-amber-500" href="'.$this->url_to_absolute($row->homepage).'">Link</a>' : null
                  )
                  ->html(),
            Column::make('Orange-Pilled', 'orange_pilled')
                  ->label(fn($row, Column $column) => view('columns.book_cases.oranged-pilled')
                      ->withRow($row)
                      ->withCountry($this->country))
        ];
    }

    private function url_to_absolute($url)
    {
        if (str($url)->contains('http')) {
            return $url;
        }
        if (!str($url)->contains('http')) {
            return str($url)->prepend('https://');
        }
    }

    public function builder(): Builder
    {
        return BookCase::query()
                       ->withCount([
                           'orangePills',
                       ]);
    }

    public function viewHistoryModal($modelId): void
    {
        $this->viewingModal = true;
        $this->currentModal = BookCase::findOrFail($modelId);
    }

    public function submit(): void
    {
        $this->validate([
            'orangepill.amount' => 'required|numeric',
            'orangepill.date'   => 'required|date',
            'photo'             => 'image|max:8192', // 8MB Max
        ]);
        $orangePill = OrangePill::create([
            'user_id'      => auth()->id(),
            'book_case_id' => $this->currentModal->id,
            'amount'       => $this->orangepill['amount'],
            'date'         => $this->orangepill['date'],
        ]);
        $orangePill
            ->addMedia($this->photo)
            ->preservingOriginal()
            ->toMediaCollection('images');
        $orangePill->load(['media']);
        $this->currentModal
            ->addMedia($this->photo)
            ->toMediaCollection('images');
        if ($this->orangepill['comment']) {
            $this->currentModal->comment($this->orangepill['comment'], null);
        }
        $this->resetModal();
        $this->emit('refreshDatatable');
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
