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
    public function getUsersWithRole()
    {
        $users = User::all();
        foreach ($users as $key => $user) {
            $user_roles = $user->user_role()->get();
            $roles = array();
            foreach ($user_roles as $key => $user_role) {
                $role = $user_role->role()->first();
                $decode_role = json_decode($role, true);
                unset($decode_role["created_at"]);
                unset($decode_role["updated_at"]);
                array_push($roles, $decode_role);
            }
            $user["roles"] = $roles;
        }
        return $users;
    }
    public function getUserById($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        $user_roles = $user->user_role()->get();
        $roles = array();
        foreach ($user_roles as $key => $user_role) {
            $role = $user_role->role()->first();
            $decode_role = json_decode($role, true);
            unset($decode_role["created_at"]);
            unset($decode_role["updated_at"]);
            array_push($roles, $decode_role);
        }
        $user["roles"] = $roles;
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
                $user->user_type = $data['group'];
                $user->email = $data['email'];
                $user->save();
            } else {
                $user->name_th = $data['name_th'];
                $user->name_en = $data['name'];
                $user->user_type = $data['group'];
                $user->email = $data['email'];
                $user->save();
            }
            return $user;
        } catch (\Throwable $th) {
            return  false;
        }
    }
}
