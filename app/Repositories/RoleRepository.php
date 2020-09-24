<?php

namespace App\Repositories;

use App\Model\Role;
use App\Model\UserRole;
use App\Model\User;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRole()
    {
        return Role::all();
    }

    public function createUserRole($data)
    {
        $hasRole = UserRole::where("user_id", $data["user_id"])->where("role_id", $data["role_id"])->first();
        if (!$hasRole) {
            $user_role = new UserRole;
            $user_role->user_id = $data["user_id"];
            $user_role->role_id = $data["role_id"];
            $user_role->save();
            return true;
        }
        return false;
    }
    public function removeUserRole($data)
    {
        $hasRole = UserRole::where("user_id", $data["user_id"])->where("role_id", $data["role_id"])->delete();
        if ($hasRole) {
            return true;
        }
        return false;
    }
}
