<?php

namespace App\Repositories;


interface ApplicationRepositoryInterface
{
    public function getApplicationById($id);
    public function getApplicationByAppId($app_id);
    public function getAllByStatus($status);
    public function getAllByUserId($user_id);
    public function getAllApplications();
    public function createApplication($data);
    public function upsertPage($data);
    public function updateApplication($data);
    public function updateStatusApplicationById($data);
    public function deleteApplicationById($id);
}
