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
    public function getlUserById($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        return $user;
    }
    public function createlUser($data)
    {

        $user = User::where('user_id', $data['uid'])->first();
        try {
            if (!$user) {
                $user = new User;
                $user->user_id = $data['uid'];
                $user->name_th = $data['name_th'];
                $user->name_en = $data['name'];
                $user->email = $data['email'];
                $user->save();
            } else {
                $user->name_th = $data['name_th'];
                $user->name_en = $data['name'];
                $user->email = $data['email'];
                $user->save();
            }
            return true;
        } catch (\Throwable $th) {
            return  false;
        }
    }
}
