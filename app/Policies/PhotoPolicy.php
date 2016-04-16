<?php

namespace App\Policies;

use App\Photo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
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

    public function edit(User $user, Photo $photo)
    {
        return $user->id == $photo->miniature->collection->user->id;
    }

    public function delete(User $user, Photo $photo)
    {
        return $user->id == $photo->imageable->collection->user->id;
    }
}
