<?php

namespace App\Repositories;

use App\Model\Application;
use App\Model\ApplicationConfig;
use App\Model\Page;
use Illuminate\Support\Arr;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    private $BUTTON_COLOR = "BUTTON_COLOR";
    private $BUTTON_TEXT_COLOR = "BUTTON_TEXT_COLOR";
    private $BUTTON_HOVER_COLOR = "BUTTON_HOVER_COLOR";
    private $BUTTON_HOVER_TEXT_COLOR = "BUTTON_HOVER_TEXT_COLOR";
    private $SIGN_IN_WORD = "SIGN_IN_WORD";
    private $LABEL_WORD = "LABEL_WORD";
    private $IMAGE_URL = "IMAGE_URL";
    private $TEXT_COLOR = "TEXT_COLOR";
    private $BACKGROUND_COLOR = "BACKGROUND_COLOR";
    private $ICON_COLOR = "ICON_COLOR";
    private $ALL_CONFIGS = ["ICON_COLOR", "BACKGROUND_COLOR", "BUTTON_COLOR", "BUTTON_TEXT_COLOR", "BUTTON_HOVER_COLOR", "BUTTON_HOVER_TEXT_COLOR", "SIGN_IN_WORD", "LABEL_WORD", "IMAGE_URL", "TEXT_COLOR"];

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
        if ($app) {
            $app["app_config"] = $app->application_config()->first();
            $pages = [];
            foreach ($app->pages()->get() as $value) {
                $pages[$value->key] = $value->value;
            }
            $app["app_pages"] = $pages;
        }
        return $app;
    }

    public function getApplicationById($id)
    {
        $app = Application::where('id', $id)->first();
        if ($app) {
            $app["app_config"] = $app->application_config()->first();
            $pages = [];
            foreach ($app->pages()->get() as $value) {
                $pages[$value->key] = $value->value;
            }
            $app["app_pages"] = $pages;
        }
        return $app;
    }

    public function createApplication($data)
    {
        $app = new Application();
        $app->app_id = generateCode(8);
        $app->secret_id = generateCode(25);
        $app->name = $data["name"];
        $app->user_id = $data["user_id"];
        $app->detail = $data["detail"];
        $app->save();

        $app_config = new ApplicationConfig();
        $app_config->app_id = $app->id;
        $app_config->redirect_uri = Arr::get($data, 'redirect_uri', "");
        $app_config->save();

        return $app;
    }

    public function updateApplication($data)
    {
        $app = Application::where("id", $data["id"])->where("user_id", $data["user_id"])->first();
        if (!$app) {
            return false;
        }
        $app->detail = $data["detail"];
        $app_config = $app->application_config()->first();

        $app_config->redirect_uri = Arr::get($data, 'redirect_uri', "");
        $app_config->save();
        $app->save();


        return $app;
    }

    public function upsertPage($data)
    {
        foreach ($this->ALL_CONFIGS as $config_key) {
            $page = Page::where("app_id", "$data[app_id]")->where("key", $config_key)->first();
            if ($page) {
                $page->value = $data[$config_key];
                $page->save();
            } else {
                $page = new Page;
                $page->app_id = $data["app_id"];
                $page->key = $config_key;
                $page->value = $data[$config_key];
                $page->save();
            }
        }
        return;
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
