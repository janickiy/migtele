<?php

namespace App\Observers;

use App\Mail\UserRegister;
use App\Model\User;

class UserObserver
{


    /**
     * @param User $user
     */
    public function creating(User $user)
    {
        $password = '';

        if(!$user->password){

            $password = str_random(6);

            session(['temp_password' => $password]);

            $user->password = bcrypt($password);

        }

        \Mail::to($user)->send(new UserRegister($user, $password));


    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}