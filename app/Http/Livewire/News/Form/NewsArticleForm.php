<?php

namespace App\Http\Livewire\News\Form;

use App\Models\LibraryItem;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewsArticleForm extends Component
{
    use WithFileUploads;

    public ?LibraryItem $libraryItem = null;
    public $image;
    public $currentImage = 0;
    public $images;
    public $imagesCloned = [];
    public array $temporaryUrls = [];

    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:10240',

            'libraryItem.lecturer_id'        => 'required',
            'libraryItem.name'               => 'required',
            'libraryItem.type'               => 'required',
            'libraryItem.language_code'      => 'required',
            'libraryItem.value'              => 'required',
            'libraryItem.subtitle'           => 'required',
            'libraryItem.excerpt'            => 'required',
            'libraryItem.main_image_caption' => 'required',
            'libraryItem.read_time'          => 'required',
            'libraryItem.approved'           => 'boolean',
        ];
    }

    public function mount()
    {
        if ($this->libraryItem === null) {
            $this->libraryItem = new LibraryItem([
                'type'          => 'markdown_article',
                'value'         => '',
                'read_time'     => 1,
                'language_code' => 'de',
                'approved'      => auth()
                    ->user()
                    ->hasRole('news-editor'),
            ]);
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

        $this->libraryItem->addMedia($this->image)
                          ->toMediaCollection('main');

        return to_route('article.overview', ['country' => null]);
    }

    public function render()
    {
        return view('livewire.news.form.news-article-form');
    }
}
