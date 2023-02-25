<?php

namespace App\Http\Livewire\Venue\Form;

use App\Models\Venue;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class VenueForm extends Component
{
    use WithFileUploads;
    use Actions;

    public string $country;

    public ?Venue $venue = null;

    public $images;

    public ?string $fromUrl = '';

    protected $queryString = ['fromUrl' => ['except' => '']];

    public function rules()
    {
        return [
            'images.*' => [Rule::requiredIf(!$this->venue->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'venue.city_id' => 'required',
            'venue.name'    => 'required',
            'venue.street'  => 'required',
        ];
    }

    public function mount()
    {
        if (!$this->venue) {
            $this->venue = new Venue();
        } elseif (!auth()
            ->user()
            ->can('update', $this->venue)) {
            abort(403);
        }

        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function submit()
    {
        $this->validate();
        $this->venue->save();

        if (count($this->images) > 0) {
            foreach ($this->images as $item) {
                $this->venue->addMedia($item)
                            ->toMediaCollection('images');
            }
        }

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.venue.form.venue-form');
    }
}
