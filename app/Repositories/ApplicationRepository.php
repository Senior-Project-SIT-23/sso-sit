<?php

namespace App\Repositories;

use App\Model\Application;
use App\Model\ApplicationConfig;
use App\Model\Page;

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

    public function createApplication($data)
    {
        $app = new Application();
        $app->app_id = generateCode(5);
        $app->secret_id = generateCode(8);
        $app->name = $data["name"];
        $app->user_id = $data["user_id"];
        $app->detail = $data["detail"];
        $app->save();

        $app_config = new ApplicationConfig();
        $app_config->policy = $data["policy"];
        $app_config->app_id = $app->id;
        $app_config->save();

        $page = new Page();
        $page->app_id = $app->id;
        $page->save();

        return $app;
    }

    public function updateApplication($data)
    {
        $app = Application::where("id", $data["id"])->first();
        $app->name = $data["name"];
        $app->user_id = $data["user_id"];
        $app->detail = $data["detail"];
        $app->save();

        $app_config = $app->application_config()->first();
        $app_config->policy = $data["policy"];
        $app_config->save();

        $page = $app->pages()->first();
        $page->save();

        return $app;
    }

    public function updateStatusApplicationById($data)
    {
        $app = Application::where("id", $data["id"])->first();
        $app->status = $data["status"];
        $app->save();

        return $app;
    }
    public function deleteApplicationById($id)
    {
        $app = Application::where("id", $id)->delete();
        return $app;
    }
}
