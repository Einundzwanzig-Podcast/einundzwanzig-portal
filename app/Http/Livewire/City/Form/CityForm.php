<?php

namespace App\Http\Livewire\City\Form;

use App\Models\City;
use Livewire\Component;

class CityForm extends Component
{
    public ?City $city = null;

    public string $fromUrl = '';

    protected $queryString = [
        'fromUrl' => [
            'except' => null,
        ],
    ];

    public function rules()
    {
        return [
            'city.country_id' => 'required',
            'city.name'       => 'required|string',
            'city.longitude'  => 'required',
            'city.latitude'   => 'required',
        ];
    }

    public function mount()
    {
        if (!$this->city) {
            $this->city = new City();
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function save()
    {
        $this->validate();
        $this->city->longitude = str($this->city->longitude)
            ->replace(',', '.')
            ->toFloat();
        $this->city->latitude = str($this->city->latitude)
            ->replace(',', '.')
            ->toFloat();
        $this->city->save();

        return redirect($this->fromUrl ?? url()->route('welcome'));
    }

    public function render()
    {
        return view('livewire.city.form.city-form');
    }
}
