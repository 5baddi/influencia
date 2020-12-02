<?php

namespace App\Policies;

use App\User;
use App\Influencer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class InfluencerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Influencer  $influencer
     * @return mixed
     */
    public function delete(User $user, Influencer $influencer)
    {
        return Gate::allows('delete_influencer') || $user->is_superadmin;
    }
}
