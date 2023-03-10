<?php

namespace App\Policies;

use App\Models\ProjectProposal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectProposalPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectProposal $projectProposal): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectProposal $projectProposal): bool
    {
        return $projectProposal->created_by === $user->id || $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectProposal $projectProposal): bool
    {
        return $projectProposal->created_by === $user->id || $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectProposal $projectProposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectProposal $projectProposal): bool
    {
        return false;
    }
}
