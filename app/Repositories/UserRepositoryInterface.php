<?php

namespace App\Repositories;


interface UserRepositoryInterface
{
    public function getAllUser();
    public function createlUser($data);
}
