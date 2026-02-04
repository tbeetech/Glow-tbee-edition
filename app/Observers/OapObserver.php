<?php

namespace App\Observers;

use App\Models\Show\OAP;
use App\Support\PersonProfileSync;

class OapObserver
{
    public function saved(OAP $oap): void
    {
        if (
            !$oap->wasRecentlyCreated
            && !$oap->wasChanged([
                'staff_member_id',
                'name',
                'bio',
                'profile_photo',
                'email',
                'department_id',
                'team_role_id',
                'phone',
                'social_media',
                'employment_status',
                'is_active',
                'joined_date',
            ])
        ) {
            return;
        }

        PersonProfileSync::fromOap($oap);
    }
}
