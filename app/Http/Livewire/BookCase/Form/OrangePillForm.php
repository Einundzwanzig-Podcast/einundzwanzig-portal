<?php

namespace App\Http\Livewire\BookCase\Form;

use App\Models\BookCase;
use App\Models\Country;
use App\Models\OrangePill;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrangePillForm extends Component
{
    use WithFileUploads;

    public Country $country;

    public BookCase $bookCase;

    public ?OrangePill $orangePill = null;

    public $image;

    public string $fromUrl = '';

    protected $queryString = ['fromUrl' => ['except' => '']];

    public function rules()
    {
        return [
            'orangePill.book_case_id' => 'required',
            'orangePill.user_id' => 'required',
            'orangePill.amount' => 'required|numeric',
            'orangePill.date' => 'required|date',
            'orangePill.comment' => 'required|string',
            'image' => 'image|max:8192', // 8MB Max
        ];
    }

    public function mount()
    {
        if (! $this->orangePill) {
            $this->orangePill = new OrangePill([
                'user_id' => auth()->id(),
                'book_case_id' => $this->bookCase->id,
                'date' => now(),
                'amount' => 1,
            ]);
        } elseif ($this->orangePill->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function save()
    {
        $this->validate();
        $this->orangePill->save();
        $this->orangePill
            ->addMedia($this->image)
            ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
            ->toMediaCollection('images');

        return redirect($this->fromUrl);
    }

    public function deleteMe()
    {
        $this->orangePill->delete();

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.book-case.form.orange-pill-form');
    }
}
