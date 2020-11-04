<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApplicationRepositoryInterface;
use App\Repositories\HistoryRepositoryInterface;

class ApplicationController extends Controller
{
    private $app;
    private $history;

    public function __construct(ApplicationRepositoryInterface $app, HistoryRepositoryInterface $history)
    {
        $this->app = $app;
        $this->history = $history;
    }

    public function getApplicationByAppId(Request $request, $app_id)
    {
        $applications = $this->app->getApplicationByAppId($app_id);
        if ($applications) {
            if ($applications->status !== "approve") {
                return response()->json(["message" => "can not auth with this application ( application still not approved ) "], 403);
            } else {
                if ($applications->app_config->redirect_uri === $request->all()["redirect_uri"]) {
                    return response()->json(["message" => "app found"], 200);
                } else {
                    return response()->json(["message" => "No match Redirect uri please check your redirect in your application config"], 403);
                }
            }
        }
        return response()->json(["message" => "app not found"], 404);
    }

    public function getApplicationById(Request $request, $id)
    {
        $user_id = $request->all()["user_id"];
        $applications = $this->app->getApplicationById($id);
        if ($applications) {
            $log_history = ["key" => "GetApplication", "value" => "success to get appID : $id", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($applications, 200);
        }
        $log_history = ["key" => "GetApplication", "value" => "fail to get appID : $id", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json(["message" => "app not found"], 404);
    }

    public function indexMe(Request $request)
    {
        $data["user_id"] = $request->all()["user_id"];
        $user_id = $request->all()["user_id"];
        $applications = $this->app->getAllByUserId($data);
        if ($applications) {
            $log_history = ["key" => "GetAllApplication", "value" => "success to get apps", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($applications, 200);
        }
        $log_history = ["key" => "GetAllApplication", "value" => "fail to get apps", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("not found Applications", 404);
    }

    public function indexPending(Request $request)
    {
        $applications = $this->app->getAllByStatus("pending");
        $user_id = $request->all()["user_id"];
        if ($applications) {
            $log_history = ["key" => "GetAllApplicationPending", "value" => "success to get apps", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($applications, 200);
        }
        $log_history = ["key" => "GetAllApplicationPending", "value" => "fail to get apps", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("not found Applications", 404);
    }

    public function indexApprove(Request $request)
    {
        $applications = $this->app->getAllByStatus("approve");
        $user_id = $request->all()["user_id"];
        if ($applications) {
            $log_history = ["key" => "GetAllApplicationApprove", "value" => "success to get apps", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($applications, 200);
        }
        $log_history = ["key" => "GetAllApplicationApprove", "value" => "fail to get apps", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("not found Applications", 404);
    }

    public function indexReject(Request $request)
    {
        $applications = $this->app->getAllByStatus("reject");
        $user_id = $request->all()["user_id"];
        if ($applications) {
            $log_history = ["key" => "GetAllApplicationReject", "value" => "success to get apps", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($applications, 200);
        }
        $log_history = ["key" => "GetAllApplicationReject", "value" => "fail to get apps", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("not found Applications", 404);
    }

    public function checkSecret(Request $request, $app_id)
    {
        $data = $request->all();
        $client_secret = $data["client_secret"];
        $redirect_uri = $data["redirect_uri"];
        $application = $this->app->getApplicationByAppId($app_id);
        if (!$application) {
            return response()->json(["message" => "not match"], 404);
        }
        if ($client_secret == $application->secret_id) {
            if ($redirect_uri == $application->app_config->redirect_uri) {
                return response()->json(["message" => "match!!"], 200);
            } else {
                return response()->json(["message" => "not match redirect uri"], 404);
            }
            return response()->json(["message" => "match!!"], 200);
        } else {
            return response()->json(["message" => "not match client secret"], 404);
        }
    }

    public function store(Request $request)
    {
        $data = json_decode($request->all()["data"], true);
        $data["user_id"] = $request->all()["user_id"];
        $application = $this->app->createApplication($data);
        $user_id = $request->all()["user_id"];

        if ($application) {
            $log_history = ["key" => "CreateAllApplication", "value" => "success to create apps", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($application, 200);
        }
        $log_history = ["key" => "CreateAllApplication", "value" => "fail to create apps", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("something wrong", 400);
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->all()["data"], true);
        $data["user_id"] = $request->all()["user_id"];
        $data["id"] = $id;
        $user_id = $request->all()["user_id"];

        $application = $this->app->updateApplication($data);
        if ($application) {
            $log_history = ["key" => "UpdateApplication", "value" => "success to update app : $id", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($application, 200);
        }
        $log_history = ["key" => "UpdateApplication", "value" => "fail to update app : $id", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("Application not found", 400);
    }

    public function updateStatusById(Request $request, $id)
    {
        $data = json_decode($request->all()["data"], true);
        $data["id"] = $id;
        $user_id = $request->all()["user_id"];

        $application = $this->app->updateStatusApplicationById($data);
        if ($application) {
            $log_history = ["key" => "UpdateStatusApplication", "value" => "success to update status app : $id", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($application, 200);
        }
        $log_history = ["key" => "UpdateStatusApplication", "value" => "fail to update status app : $id", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("something wrong", 400);
    }

    public function destroy(Request $request, $id)
    {
        $application = $this->app->deleteApplicationById($id);
        $user_id = $request->all()["user_id"];
        if ($application) {
            $log_history = ["key" => "DeleteApplication", "value" => "success to delete apps : $id", "user_id" => $user_id];
            $this->history->createHistory($log_history);
            return response()->json($application, 200);
        }
        $log_history = ["key" => "DeleteApplication", "value" => "fail to delete apps : $id", "user_id" => $user_id];
        $this->history->createHistory($log_history);
        return response()->json("something wrong", 400);
    }
}
