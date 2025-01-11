<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;

class EntryPolicy
{
    public function delete(User $user, Entry $entry): bool
    {
        return $entry->user()->is($user);
    }

    public function update(User $user, Entry $entry): bool
    {
        return $entry->user()->is($user);
    }
}
