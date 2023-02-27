<?php

namespace App\Http\Livewire\ContentCreator\Form;

use App\Models\Lecturer;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContentCreatorForm extends Component
{
    use WithFileUploads;

    public ?Lecturer $lecturer = null;

    public $image;

    public ?string $fromUrl = '';

    protected $queryString = ['fromUrl' => ['except' => '']];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->lecturer->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'lecturer.name'              => [
                'required',
                Rule::unique('lecturers', 'name')
                    ->ignore($this->lecturer),
            ],
            'lecturer.active'            => 'boolean',
            'lecturer.subtitle'          => 'nullable|string',
            'lecturer.intro'             => 'nullable|string',
            'lecturer.nostr'             => 'nullable|string',
            'lecturer.twitter_username'  => 'nullable|string',
            'lecturer.website'           => 'nullable|url',
            'lecturer.lightning_address' => 'nullable|string',
            'lecturer.lnurl'             => 'nullable|string',
            'lecturer.node_id'           => 'nullable|string',
        ];
    }

    public function mount()
    {
        if (!$this->lecturer) {
            $this->lecturer = new Lecturer([
                'intro'   => '',
                'active'  => true,
            ]);
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function save()
    {
        $this->validate();
        $this->lecturer->save();

        if ($this->image) {
            $this->lecturer->addMedia($this->image)
                           ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
                           ->toMediaCollection('avatar');
        }

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.content-creator.form.content-creator-form');
    }
}
