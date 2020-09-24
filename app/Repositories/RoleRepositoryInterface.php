<?php

namespace App\Repositories;


interface RoleRepositoryInterface
{
    public function getAllRole();
    public function createUserRole($data);
    public function removeUserRole($data);
}
