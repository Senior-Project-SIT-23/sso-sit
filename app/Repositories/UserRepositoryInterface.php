<?php

namespace App\Repositories;


interface UserRepositoryInterface
{
    public function getAllUser();
    public function getUsersWithRole();
    public function getUserById($data);
    public function createlUser($data);
}
