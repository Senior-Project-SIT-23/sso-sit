<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApplicationRepositoryInterface;

class ApplicationController extends Controller
{
    private $app;

    public function __construct(ApplicationRepositoryInterface $app)
    {
        $this->app = $app;
    }

    public function getApplicationByAppId(Request $request, $app_id)
    {
        $applications = $this->app->getApplicationByAppId($app_id);
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json(["message" => "app not found"], 404);
    }

    public function getApplicationById(Request $request, $id)
    {
        $applications = $this->app->getApplicationById($id);
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json(["message" => "app not found"], 404);
    }

    public function indexMe(Request $request)
    {
        $data["user_id"] = $request->all()["user_id"];
        $applications = $this->app->getAllByUserId($data);
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json("not found Applications", 404);
    }

    public function indexPending(Request $request)
    {
        $applications = $this->app->getAllByStatus("pending");
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json("not found Applications", 404);
    }

    public function indexApprove(Request $request)
    {
        $applications = $this->app->getAllByStatus("approve");
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json("not found Applications", 404);
    }

    public function indexReject(Request $request)
    {
        $applications = $this->app->getAllByStatus("reject");
        if ($applications) {
            return response()->json($applications, 200);
        }
        return response()->json("not found Applications", 404);
    }

    public function checkSecret(Request $request, $app_id)
    {
        $data = $request->all();
        $client_secret = $data["client_secret"];
        $application = $this->app->getApplicationById($app_id);
        if (!$application) {
            return response()->json(["message" => "not match"], 404);
        }
        if ($client_secret == $application->secret_id) {
            return response()->json(["message" => "matach!!"], 200);
        } else {
            return response()->json(["message" => "not match"], 404);
        }
    }

    public function store(Request $request)
    {
        $data = json_decode($request->all()["data"], true);
        $data["user_id"] = $request->all()["user_id"];
        $application = $this->app->createApplication($data);
        if ($application) {
            return response()->json($application, 200);
        }
        return response()->json("something wrong", 400);
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->all()["data"], true);
        $data["user_id"] = $request->all()["user_id"];
        $data["id"] = $id;
        $application = $this->app->updateApplication($data);
        if ($application) {
            return response()->json($application, 200);
        }
        return response()->json("something wrong", 400);
    }

    public function updateStatusById(Request $request, $id)
    {
        $data = json_decode($request->all()["data"], true);
        $data["id"] = $id;
        $application = $this->app->updateStatusApplicationById($data);
        if ($application) {
            return response()->json($application, 200);
        }
        return response()->json("something wrong", 400);
    }
    public function destroy($id)
    {
        $application = $this->app->deleteApplicationById($id);
        if ($application) {
            return response()->json($application, 200);
        }
        return response()->json("something wrong", 400);
    }
}
