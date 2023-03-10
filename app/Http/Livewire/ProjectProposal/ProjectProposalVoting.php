<?php

namespace App\Http\Livewire\ProjectProposal;

use App\Models\Country;
use App\Models\ProjectProposal;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Validation\Rule;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ProjectProposalVoting extends Component
{
    public ?ProjectProposal $projectProposal = null;
    public ?Vote $vote = null;

    public ?string $fromUrl = '';

    protected $queryString = [
        'fromUrl' => ['except' => ''],
    ];

    public function rules()
    {
        return [
            'vote.user_id'             => 'required',
            'vote.project_proposal_id' => 'required',
            'vote.value'               => 'required|boolean',
            'vote.reason'              => [
                Rule::requiredIf(!$this->vote->value),
            ]
        ];
    }

    public function mount()
    {
        $this->projectProposal->load('votes');
        $vote = Vote::query()
                    ->where('user_id', auth()->id())
                    ->where('project_proposal_id', $this->projectProposal->id)
                    ->first();
        if ($vote) {
            $this->vote = $vote;
        } else {
            $this->vote = new Vote();
            $this->vote->user_id = auth()->id();
            $this->vote->project_proposal_id = $this->projectProposal->id;
            $this->vote->value = false;
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function yes()
    {
        $this->vote->value = true;
        $this->vote->save();

        return to_route('project.voting.projectFunding',
            ['projectProposal' => $this->projectProposal, 'fromUrl' => $this->fromUrl]);
    }

    public function no()
    {
        $this->validate();

        $this->vote->value = false;
        $this->vote->save();

        return to_route('project.voting.projectFunding',
            ['projectProposal' => $this->projectProposal, 'fromUrl' => $this->fromUrl]);
    }

    public function render()
    {
        return view('livewire.project-proposal.project-proposal-voting', [
            'entitledVoters' => User::query()
                                    ->with([
                                        'votes' => fn($query) => $query->where('project_proposal_id',
                                            $this->projectProposal->id)
                                    ])
                                    ->withCount([
                                        'votes' => fn($query) => $query->where('project_proposal_id',
                                            $this->projectProposal->id)
                                    ])
                                    ->whereHas('roles', function ($query) {
                                        return $query->where('roles.name', 'entitled-voter');
                                    })
                                    ->orderByDesc('votes_count')
                                    ->get(),
            'otherVoters'    => User::query()
                                    ->with([
                                        'votes' => fn($query) => $query->where('project_proposal_id',
                                            $this->projectProposal->id)
                                    ])
                                    ->withCount([
                                        'votes' => fn($query) => $query->where('project_proposal_id',
                                            $this->projectProposal->id)
                                    ])
                                    ->whereDoesntHave('roles', function ($query) {
                                        return $query->where('roles.name', 'entitled-voter');
                                    })
                                    ->orderByDesc('votes_count')
                                    ->get(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Project Proposal'),
                description: __('Submit a project proposal and let the community vote on it through the elected voters. All other community members can also vote.'),
                image: asset('img/voting.jpg')
            ),
        ]);
    }
}
