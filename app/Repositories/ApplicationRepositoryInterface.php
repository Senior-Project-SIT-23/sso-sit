<?php

namespace App\Repositories;


interface ApplicationRepositoryInterface
{
    public function getApplicationById($app_id);
    public function getAllApplications();
    public function createApplication($data);
    public function updateApplication($data);
    public function updateStatusApplicationById($data);
    public function deleteApplicationById($id);
}
