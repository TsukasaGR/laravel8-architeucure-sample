<?php

namespace App\Policies\Models;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
