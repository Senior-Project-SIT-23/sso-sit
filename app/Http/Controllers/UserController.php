<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    private $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $is_created = $this->user->createlUser($data['sync_attrs']);
        if ($is_created) {
            return response()->json(["mesage" => "created/updated"], 200);
        } else {
            return response()->json(["mesage" => "fail create or update user something went wrong in service sso_mange pls contact developer"], 500);
        }
    }

    public function getUserById(Request $request, $user_id)
    {
        $user = $this->user->getUserById($user_id);
        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(["mesage" => "user not found"], 404);
        }
    }

    public function getUsersWithRole(Request $request)
    {
        $users = $this->user->getUsersWithRole();
        return response()->json($users, 200);
    }
}
