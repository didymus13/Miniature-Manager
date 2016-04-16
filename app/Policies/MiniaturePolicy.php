<?php

namespace App\Policies;

use App\Miniature;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MiniaturePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Miniature $mini)
    {
        return $user->id == $mini->collection->user->id;
    }

    public function delete(User $user, Miniature $mini)
    {
        return $user->id == $mini->collection->user->id;
    }
}
