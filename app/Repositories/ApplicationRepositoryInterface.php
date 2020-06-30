<?php

namespace App\Repositories;


interface ApplicationRepositoryInterface
{
    public function getApplicationById($app_id);
    public function getAllApplications();
}
