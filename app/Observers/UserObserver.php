<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function deleted(User $user): void
    {
        $user->logs()->update([
            'description' => 'User deleted',
        ]);
    }

    public function created(User $user): void
    {
        $user->logs()->create([
            'description' => 'User created',
        ]);
    }
    public function updated(User $user): void
    {
        $user->logs()->update([
            'description' => 'User updated',
        ]);
    }


}
