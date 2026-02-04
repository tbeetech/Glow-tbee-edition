<?php

namespace App\Observers;

use App\Models\User;
use App\Support\PersonProfileSync;

class UserObserver
{
    public function saved(User $user): void
    {
        if (
            !$user->wasRecentlyCreated
            && !$user->wasChanged([
                'name',
                'email',
                'avatar',
                'bio',
                'department_id',
                'team_role_id',
                'is_active',
            ])
        ) {
            return;
        }

        PersonProfileSync::fromUser($user);
    }
}
