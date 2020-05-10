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
    public function createlUser($data)
    {

        $user = User::where('id', $data['uid'])->first();
        try {
            if (!$user) {
                $user = new User;
                $user->id = $data['uid'];
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
