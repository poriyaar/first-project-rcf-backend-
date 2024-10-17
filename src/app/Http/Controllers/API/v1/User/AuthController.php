<?php

namespace App\Http\Controllers\API\v1\user;


use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    public function userNotification()
    {
        return response()->json([
            auth()->user()->unreadnotifications()
        ], Response::HTTP_OK);
    }


    public function leaderboards()
    {
        return resolve(UserRepository::class)->leaderboards();
    }
}
