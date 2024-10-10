<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * Register new user
     * @method POST
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
        resolve(UserRepository::class)->create($request);

        return response()->json(['message' => 'User created successfully'] , Response::HTTP_CREATED);
    }

     /**
      * Login user
     * @method GET
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {

        //  Validate form inputs
        $request->validate([
            'email' => ['required' , 'email'],
            'password' => ['required'],
        ]);

        // check user Credentials For Login
        if (Auth::attempt($request->only(['email' , 'password']))) {
            return response()->json(Auth::user() , Response::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'email' => 'incorrect credentials'
        ]);

    }


    public function user()
    {
        return response()->json(Auth::user() ,  Response::HTTP_OK);
    }


    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => "logged out successfully"
        ] ,  Response::HTTP_OK);
    }
}
