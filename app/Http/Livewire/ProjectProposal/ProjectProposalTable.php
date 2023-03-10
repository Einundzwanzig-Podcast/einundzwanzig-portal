<?php

namespace App\Http\Livewire\ProjectProposal;

use App\Models\Country;
use Livewire\Component;

class ProjectProposalTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.project-proposal.project-proposal-table');
    }
}
