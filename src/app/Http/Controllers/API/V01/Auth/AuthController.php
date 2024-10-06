<?php

namespace App\Http\Controllers\API\V01\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Register new user
     * @method Post
     * @param Request $request
     */

    // validate form inputs
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required' , 'email', 'unique:users'],
            'password' => ['required'],
        ]);
        // insert user into database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->name),
        ]);

        return response()->json(['message' => 'User created successfully'] , 201);
    }

    public function login(Request $request)
    {

    }

    public function logout()
    {

    }
}
