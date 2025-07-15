<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ActivityLog;

class ActivityLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, ActivityLog $activityLog): bool
    {
        return $user->role === 'admin';
    }
}
