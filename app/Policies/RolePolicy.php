<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function view(User $user)
    {
        return $user->role >= 1;
    }

    public function create(User $user)
    {
        return $user->role >= 2;
    }

    public function update(User $user)
    {
        return $user->role >= 3;
    }

    public function delete(User $user)
    {
        return $user->role >= 4;
    }
}
