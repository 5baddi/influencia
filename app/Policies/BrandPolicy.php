<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
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
     * @param  \App\Brand  $brand
     * @return mixed
     */
    public function view(User $user, Brand $brand)
    {
        $related = $brand->load('users')->users->find($user);

        return !is_null($related) || $user->is_superadmin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Gate::allows('create_brand') || $user->is_superadmin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Brand  $brand
     * @return mixed
     */
    public function update(User $user, Brand $brand)
    {
        $related = $brand->load('users')->users->find($user);

        return (Gate::allows('edit_brand') && !is_null($related)) || $user->is_superadmin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Brand  $brand
     * @return mixed
     */
    public function delete(User $user, Brand $brand)
    {
        $related = $brand->load('users')->users->find($user);

        return (Gate::allows('delete_brand') && !is_null($related)) || $user->is_superadmin;
    }
}
