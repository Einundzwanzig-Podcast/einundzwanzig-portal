<?php

namespace App\Http\Livewire\ProjectProposal\Form;

use App\Models\Country;
use App\Models\ProjectProposal;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectProposalForm extends Component
{
    use WithFileUploads;

    public Country $country;

    public ?ProjectProposal $projectProposal = null;

    public $image;

    public ?string $fromUrl = '';

    protected $queryString = [
        'fromUrl' => ['except' => ''],
    ];

    public function rules()
    {
        return [
            'image' => [
                'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'
            ],

            'projectProposal.user_id'         => 'required',
            'projectProposal.name'            => 'required',
            'projectProposal.support_in_sats' => 'required|numeric',
            'projectProposal.description'     => 'required',
        ];
    }

    public function mount()
    {
        if (!$this->projectProposal) {
            $this->projectProposal = new ProjectProposal([
                'user_id' => auth()->id(),
                'description' => '',
            ]);
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function save()
    {
        $this->validate();
        $this->projectProposal->save();

        if ($this->image) {
            $this->projectProposal->addMedia($this->image)
                              ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
                              ->toMediaCollection('main');
        }

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.project-proposal.form.project-proposal-form', [

        ]);
    }
}
