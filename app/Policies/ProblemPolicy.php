<?php

namespace App\Policies;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($userId)
    {
        $guard = auth('admin')->check() ? 'admin' : 'web';
        return auth($guard)->check() && auth($guard)->user()->hasPermissionTo('Read-Problems') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Problem $problem)
    {
        $guard = auth('admin')->check() ? 'admin' : 'web';
        return auth($guard)->check() && auth($guard)->user()->hasPermissionTo('Read-Problems') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($userId)
    {
        $guard = auth('admin')->check() ? 'admin' : 'web';
        return auth($guard)->check() && auth($guard)->user()->hasPermissionTo('Create-Problem') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($userId, Problem $problem)
    {
        return auth('admin')->check() && auth('admin')->user()->hasPermissionTo('Update-Problem') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($userId, Problem $problem)
    {
        return auth('admin')->check() && auth('admin')->user()->hasPermissionTo('Delete-Problem') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Problem $problem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Problem $problem)
    {
        //
    }
}
