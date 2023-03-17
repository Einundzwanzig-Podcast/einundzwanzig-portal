<?php

namespace App\Http\Livewire\News\Form;

use App\Models\LibraryItem;
use App\Traits\HasTagsTrait;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewsArticleForm extends Component
{
    use HasTagsTrait;
    use WithFileUploads;

    public ?LibraryItem $libraryItem = null;

    public $image;

    public $currentImage = 0;

    public $images;

    public $imagesCloned = [];

    public array $temporaryUrls = [];

    public ?string $fromUrl = '';

    public string $type = '';

    public bool $paid = false;

    protected $queryString = ['fromUrl' => ['except' => ''], 'type' => ['except' => '']];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->libraryItem->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'selectedTags' => 'array|min:1',

            'libraryItem.lecturer_id'        => 'required',
            'libraryItem.name'               => 'required',
            'libraryItem.type'               => 'required',
            'libraryItem.language_code'      => 'required',
            'libraryItem.value'              => 'required',
            'libraryItem.value_to_be_paid'   => [Rule::requiredIf($this->libraryItem->sats > 0), 'nullable', 'string',],
            'libraryItem.sats'               => [
                Rule::requiredIf($this->libraryItem->sats > 0), 'nullable', 'numeric',
            ],
            'libraryItem.subtitle'           => 'string|nullable',
            'libraryItem.excerpt'            => 'required',
            'libraryItem.main_image_caption' => 'string|nullable',
            'libraryItem.read_time'          => 'numeric|nullable',
            'libraryItem.approved'           => 'boolean',
            'libraryItem.news'               => 'boolean',
        ];
    }

    public function mount()
    {
        if ($this->type === 'paid') {
            $this->paid = true;
        }
        if (!$this->libraryItem) {
            $this->libraryItem = new LibraryItem([
                'type'             => 'markdown_article',
                'value'            => '',
                'value_to_be_paid' => '',
                'read_time'        => 1,
                'sats'             => $this->paid ? 21 : null,
                'news'             => true,
                'language_code'    => 'de',
                'approved'         => false,
            ]);
            $this->selectedTags[] = 'News';
        } else {
            $this->selectedTags = $this->libraryItem->tags()
                                                    ->where('type', 'library_item')
                                                    ->get()
                                                    ->map(fn($tag) => $tag->name)
                                                    ->toArray();
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
        if (!$this->libraryItem->value_to_be_paid) {
            $this->libraryItem->value_to_be_paid = '';
        }
    }

    public function updatedImages($value)
    {
        $clonedImages = collect($this->imagesCloned);
        $clonedImages = $clonedImages->push($value);
        $this->imagesCloned = $clonedImages->toArray();

        $temporaryUrls = collect($this->temporaryUrls);
        $temporaryUrls = $temporaryUrls->push($value->temporaryUrl());
        $this->temporaryUrls = $temporaryUrls->toArray();
    }

    public function save()
    {
        $this->validate();
        $this->libraryItem->save();

        $this->libraryItem->syncTagsWithType(
            $this->selectedTags,
            'library_item'
        );

        if ($this->image) {
            $this->libraryItem->addMedia($this->image)
                              ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
                              ->toMediaCollection('main');
        }

        return redirect($this->fromUrl);
    }

    public function delete()
    {
        $this->libraryItem->delete();

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.news.form.news-article-form');
    }
}
