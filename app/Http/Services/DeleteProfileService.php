<?php

namespace App\Http\Services;

use App\Events\ProfileDeleted;
use App\User;

class DeleteProfileService
{
    public function delete(User $user)
    {
        $tickets = $user->tickets()->pluck('id')->toArray();
        event(new ProfileDeleted($tickets));
    }
}