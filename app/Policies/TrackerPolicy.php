<?php

namespace App\Policies;

use App\Tracker;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackerPolicy
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
        return $user->is_superadmin;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tracker  $tracker
     * @return mixed
     */
    public function view(User $user, Tracker $tracker)
    {
        return ($user->id === $tracker->user_id || $user->is_superadmin);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tracker  $tracker
     * @return mixed
     */
    public function update(User $user, Tracker $tracker)
    {
        return ($user->id === $tracker->user_id || $user->is_superadmin);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tracker  $tracker
     * @return mixed
     */
    public function delete(User $user, Tracker $tracker)
    {
        return ($user->id === $tracker->user_id || $user->is_superadmin);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tracker  $tracker
     * @return mixed
     */
    public function forceDelete(User $user, Tracker $tracker)
    {
        return $user->is_superadmin;
    }
}
