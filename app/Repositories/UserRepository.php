<?php

namespace App\Repositories;

use App\Model\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUser()
    {
        $users = User::all();
        return $users;
    }
}
