<?php

namespace App\Http\Controllers\API\v1\user;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function userNotification()
    {
       return response()->json([
        auth()->user()->unreadnotifications()
       ] , Response::HTTP_OK);
    }
}
