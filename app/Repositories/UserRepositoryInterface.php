<?php

namespace App\Repositories;


interface UserRepositoryInterface
{
    public function getAllUser();
    public function getlUserById($data);
    public function createlUser($data);
}
