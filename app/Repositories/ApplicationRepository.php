<?php

namespace App\Repositories;

use App\Model\Application;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function getAllApplications()
    {
        $apps = Application::all();
        return $apps;
    }
    public function getApplicationById($app_id)
    {
        $app = Application::where('app_id', $app_id)->first();
        return $app;
    }
}
