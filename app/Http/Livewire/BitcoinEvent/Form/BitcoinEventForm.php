<?php

namespace App\Http\Livewire\BitcoinEvent\Form;

use App\Models\BitcoinEvent;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class BitcoinEventForm extends Component
{
    use WithFileUploads;
    use Actions;

    public string $country;

    public ?BitcoinEvent $bitcoinEvent = null;

    public $image;

    public ?string $fromUrl = '';

    protected $queryString = [
        'fromUrl' => [
            'except' => null,
        ],
    ];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->bitcoinEvent->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'bitcoinEvent.venue_id'       => 'required',
            'bitcoinEvent.from'           => 'required',
            'bitcoinEvent.to'             => 'required',
            'bitcoinEvent.title'          => 'required',
            'bitcoinEvent.description'    => 'required',
            'bitcoinEvent.link'           => 'required|url',
            'bitcoinEvent.show_worldwide' => 'bool',
        ];
    }

    public function mount()
    {
        if (!$this->bitcoinEvent) {
            $this->bitcoinEvent = new BitcoinEvent(
                [
                    'description'    => '',
                    'show_worldwide' => true,
                ]
            );
        } elseif (!auth()
            ->user()
            ->can('update', $this->bitcoinEvent)) {
            abort(403);
        }

        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function deleteMe()
    {
        $this->bitcoinEvent->delete();

        return redirect($this->fromUrl);
    }

    public function submit()
    {
        $this->validate();
        $this->bitcoinEvent->save();

        if ($this->image) {
            $this->bitcoinEvent->addMedia($this->image)
                               ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
                               ->toMediaCollection('logo');
        }

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.bitcoin-event.form.bitcoin-event-form');
    }
}
