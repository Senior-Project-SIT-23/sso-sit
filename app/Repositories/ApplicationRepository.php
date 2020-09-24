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

    public function getAllByUserId($user_id)
    {
        $apps = Application::where("user_id", $user_id)->get();
        foreach ($apps as $app) {
            $user = $app->user()->first();
            $app['user_name_th'] = $user->name_th;
            $app['user_name_en'] = $user->name_en;
            $app['email'] = $user->email;
        }
        return $apps;
    }

    public function getAllByStatus($status)
    {
        $apps = Application::where("status", $status)->get();
        foreach ($apps as $app) {
            $user = $app->user()->first();
            $app['user_name_th'] = $user->name_th;
            $app['user_name_en'] = $user->name_en;
            $app['email'] = $user->email;
        }
        return $apps;
    }

    public function getApplicationByAppId($app_id)
    {
        $app = Application::where('app_id', $app_id)->first();
        return $app;
    }

    public function getApplicationById($id)
    {
        $app = Application::where('id', $id)->first();

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
        $app->detail = $data["detail"];

        $app_config = $app->application_config()->first();
        $app_config->save();
        $app->save();


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
