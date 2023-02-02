<?php

namespace App\Http\Livewire\BookCase;

use App\Models\BookCase;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CommentBookCase extends Component
{
    use WithFileUploads;

    public Country $country;

    public $photo;

    public string $c = 'de';

    public BookCase $bookCase;

    public function render()
    {
        return view('livewire.book-case.comment-book-case')
            ->layout('layouts.app', [
                'SEOData' => new SEOData(
                    title: $this->bookCase->title,
                    description: $this->bookCase->address,
                    image: $this->bookCase->getFirstMediaUrl('images') ?? asset('img/bookcase.jpg'),
                )
            ]);
    }

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:4096', // 4MB Max
        ]);

        $this->bookCase
            ->addMedia($this->photo)
            ->usingFileName(md5($this->photo->getClientOriginalName()) . '.' . $this->photo->getClientOriginalExtension())
            ->toMediaCollection('images');

        return to_route('bookCases.comment.bookcase', ['country' => $this->country, 'bookCase' => $this->bookCase->id]);
    }

    public function deletePhoto($id)
    {
        Media::find($id)
             ->delete();

        return to_route('bookCases.comment.bookcase', ['country' => $this->country, 'bookCase' => $this->bookCase->id]);
    }

    protected function url_to_absolute($url)
    {
        if (str($url)->contains('http')) {
            return $url;
        }
        if (!str($url)->contains('http')) {
            return str($url)->prepend('https://');
        }
    }
}
