<?php

namespace App\Http\Livewire\Library\Form;

use App\Enums\LibraryItemType;
use App\Models\Country;
use App\Models\Library;
use App\Models\LibraryItem;
use App\Traits\HasTagsTrait;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LaravelOptions\Options;

class LibraryItemForm extends Component
{
    use HasTagsTrait;
    use WithFileUploads;

    public Country $country;

    public ?LibraryItem $libraryItem = null;

    public $library;

    public $image;

    public $file;

    public bool $lecturer = false;

    public ?string $fromUrl = '';

    protected $queryString = [
        'fromUrl' => ['except' => ''],
        'lecturer' => ['except' => false],
    ];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->libraryItem->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'library' => 'required',

            'selectedTags' => 'array|min:1',

            'libraryItem.lecturer_id' => 'required',
            'libraryItem.name' => 'required',
            'libraryItem.type' => 'required',
            'libraryItem.language_code' => 'required',
            'libraryItem.value' => [
                'required',
                Rule::when(
                    $this->libraryItem->type !== LibraryItemType::MarkdownArticle()
                    && $this->libraryItem->type !== LibraryItemType::MarkdownArticleExtern()
                    && $this->libraryItem->type !== LibraryItemType::DownloadableFile(), ['url']
                ),
            ],
            'libraryItem.subtitle' => 'required',
            'libraryItem.excerpt' =>
                [
                    Rule::when(
                        $this->libraryItem->type !== 'bindle',
                        'required',
                    )
                ],
            'libraryItem.main_image_caption' =>
                [
                    Rule::when(
                        $this->libraryItem->type !== 'bindle',
                        'required',
                    )
                ],
            'libraryItem.read_time' =>
                [
                    Rule::when(
                        $this->libraryItem->type !== 'bindle',
                        'required',
                    )
                ],
            'libraryItem.approved' =>
                [
                    Rule::when(
                        $this->libraryItem->type !== 'bindle',
                        'required',
                    )
                ],
        ];
    }

    public function mount()
    {
        if (!$this->libraryItem) {
            $this->libraryItem = new LibraryItem([
                'approved' => true,
                'read_time' => 1,
                'value' => '',
            ]);
            if ($this->lecturer) {
                $this->library = Library::query()
                    ->firstWhere('name', '=', 'Dozentenmaterial')?->id;
            }
        } else {
            $this->selectedTags = $this->libraryItem->tags()
                ->where('type', 'library_item')
                ->get()
                ->map(fn($tag) => $tag->name)
                ->toArray();
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

        $this->libraryItem->syncTagsWithType(
            $this->selectedTags,
            'library_item'
        );

        if ($this->image) {
            $this->libraryItem->addMedia($this->image)
                ->usingFileName(md5($this->image->getClientOriginalName()) . '.' . $this->image->getClientOriginalExtension())
                ->toMediaCollection('main');
        }

        if ($this->file) {
            $this->libraryItem->addMedia($this->file)
                ->usingFileName(md5($this->file->getClientOriginalName()) . '.' . $this->file->getClientOriginalExtension())
                ->toMediaCollection('single_file');
        }

        $this->libraryItem->libraries()
            ->syncWithoutDetaching([(int)$this->library]);

        if ($this->libraryItem->type === 'bindle') {
            return to_route('bindles');
        }

        return to_route('library.table.libraryItems', ['country' => $this->country]);
    }

    public function render()
    {
        $types = Options::forEnum(LibraryItemType::class)
            ->filter(
                fn($type) => $type !== LibraryItemType::PodcastEpisode
                    && $type !== LibraryItemType::MarkdownArticle
            )
            ->toArray();
        $libaries = Library::query()
            ->when(auth()->id() !== config('portal.bonus.fiat-tracker-user-id'),
                fn($query) => $query->where('name', '!=', 'Bindle')
            )
            ->get()
            ->map(fn($library) => [
                'id' => $library->id,
                'name' => $library->name,
            ])
            ->toArray();

        if (auth()->id() === config('portal.bonus.fiat-tracker-user-id')) {
            $types = collect($types)->prepend([
                'label' => 'Bindle',
                'value' => 'bindle',
            ]);
        }

        return view('livewire.library.form.library-item-form', [
            'types' => $types,
            'libraries' => $libaries,
        ]);
    }
}
