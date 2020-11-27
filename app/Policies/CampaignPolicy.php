<?php

namespace App\Policies;

use App\User;
use App\Campaign;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function view(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can change model status.
     *
     * @param  \App\User  $user
     * @param \App\Campaign $campaign
     * @return mixed
     */
    public function changeStatus(User $user, Campaign $campaign)
    {
        return ($user->id === $campaign->user_id && Gate::allows('change-status_campaign')) || $user->is_superadmin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function update(User $user, Campaign $campaign)
    {
        return ($user->id === $campaign->user_id && Gate::allows('edit_campaign')) || $user->is_superadmin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function delete(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function restore(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function forceDelete(User $user, Campaign $campaign)
    {
        //
    }
}
