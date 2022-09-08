<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->is_superadmin || Gate::allows('list_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->is_superadmin || (Gate::allows('show_user') && ($user->id === $model->id));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_superadmin || Gate::allows('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->is_superadmin || (Gate::allows('edit_user') && ($user->id === $model->id));
    }

    /**
     * Determine whether the user can ban the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function ban(User $user, User $model)
    {
        return $user->is_superadmin || (Gate::allows('ban_user') && ($user->id !== $model->id));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return (Gate::allows('delete_user') || $user->is_superadmin) && ($user->id !== $model->id);
    }
}
