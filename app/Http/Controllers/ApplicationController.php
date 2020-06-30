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

    public function getApplicationById(Request $request, $app_id)
    {
        $applications = $this->app->getApplicationById($app_id);
        return response()->json($applications, 200);
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
}
