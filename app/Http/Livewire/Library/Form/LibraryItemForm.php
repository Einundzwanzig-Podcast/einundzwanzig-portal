<?php

namespace App\Http\Livewire\Library\Form;

use App\Enums\LibraryItemType;
use App\Models\Country;
use App\Models\Library;
use App\Models\LibraryItem;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LaravelOptions\Options;

class LibraryItemForm extends Component
{
    use WithFileUploads;

    public Country $country;

    public ?LibraryItem $libraryItem = null;
    public $library;
    public $image;
    public $file;

    public bool $lecturer = false;
    public ?string $fromUrl = '';

    protected $queryString = [
        'fromUrl'  => ['except' => ''],
        'lecturer' => ['except' => false],
    ];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->libraryItem->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'library' => 'required',

            'libraryItem.lecturer_id'        => 'required',
            'libraryItem.name'               => 'required',
            'libraryItem.type'               => 'required',
            'libraryItem.language_code'      => 'required',
            'libraryItem.value'              => [
                'required',
                Rule::when(
                    $this->libraryItem->type !== LibraryItemType::MarkdownArticle
                    && $this->libraryItem->type !== LibraryItemType::MarkdownArticleExtern
                    && $this->libraryItem->type !== LibraryItemType::DownloadableFile, ['url']
                )
            ],
            'libraryItem.subtitle'           => 'required',
            'libraryItem.excerpt'            => 'required',
            'libraryItem.main_image_caption' => 'required',
            'libraryItem.read_time'          => 'required',
            'libraryItem.approved'           => 'boolean',
        ];
    }

    public function mount()
    {
        if (!$this->libraryItem) {
            $this->libraryItem = new LibraryItem([
                'approved'  => true,
                'read_time' => 1,
            ]);
            if ($this->lecturer) {
                $this->library = Library::query()
                       ->firstWhere('name', '=', 'Dozentenmaterial')?->id;
            }
        } else {
            $this->library = $this->libraryItem->libraries()
                                               ->first()
                ->id;
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function save()
    {
        $this->validate();
        $this->libraryItem->save();
        $this->libraryItem->setStatus('published');

        if ($this->image) {
            $this->libraryItem->addMedia($this->image)
                              ->toMediaCollection('main');
        }

        if ($this->file) {
            $this->libraryItem->addMedia($this->file)
                              ->toMediaCollection('single_file');
        }

        $this->libraryItem->libraries()
                          ->syncWithoutDetaching([(int) $this->library]);

        return to_route('library.table.libraryItems', ['country' => $this->country]);
    }

    public function render()
    {
        return view('livewire.library.form.library-item-form', [
            'types'     => Options::forEnum(LibraryItemType::class)
                                  ->filter(
                                      fn($type) => $type !== LibraryItemType::PodcastEpisode
                                                   && $type !== LibraryItemType::MarkdownArticle
                                  )
                                  ->toArray(),
            'libraries' => Library::query()
                                  ->where('is_public', true)
                                  ->get()
                                  ->map(fn($library) => [
                                      'id'   => $library->id,
                                      'name' => $library->name,
                                  ])
                                  ->toArray(),
        ]);
    }
}
