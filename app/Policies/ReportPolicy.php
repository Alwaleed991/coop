<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{  
    public function view(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'moderator';
    }
}
