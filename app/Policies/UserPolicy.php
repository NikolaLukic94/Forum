<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
    /* DOES PERSON WHO IS SIGNED IN HAS A PERMISSION TO UPDATE THE USER */
    public function update(User $user, User $signedInUser)
    {
        return $signedInUser->id === $user->id;
    }    
}
