<?php

namespace App\Http\Livewire\ProjectProposal;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ProjectProposalTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.project-proposal.project-proposal-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Project Proposal'),
                description: __('Submit a project proposal and let the community vote on it through the elected voters. All other community members can also vote.'),
                image: asset('img/voting.jpg')
            ),
        ]);
    }
}
