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
            return response()->json(["mesage" => "fail create or update user something went worng in service sso_mange pls contact developer"], 500);
        }
    }
}
