<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleRepositoryInterface $role)
    {
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $roles = $this->role->getAllRole();
        return response()->json($roles, 200);
    }

    public function storeUserRole(Request $request)
    {
        $data = json_decode($request->all()["data"], true);

        try {
            $isCreated = $this->role->createUserRole($data);
            if ($isCreated) {
                return response()->json(["message" => "added user in this role"], 200);
            } else {
                return response()->json(["message" => "user already this role"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "some thing error"], 500);
        }
    }

    public function destroyUserRole(Request $request)
    {
        $data = json_decode($request->all()["data"], true);

        try {
            $isCreated = $this->role->removeUserRole($data);
            if ($isCreated) {
                return response()->json(["message" => "deleted user in this role"], 200);
            } else {
                return response()->json(["message" => "user not have this role"], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "some thing error"], 500);
        }
    }
}
