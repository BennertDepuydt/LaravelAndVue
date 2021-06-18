<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255[unique:users',
            'password' => 'required|string|min:6|confirmed',
            'realfirstname' => 'required|string|max:100',
            'realsurname' => 'required|string|max:100',
            'gamefirstname' => 'required|string|max:100',
            'gamesurname' => 'required|string|max:100',
            'discordname' => 'required|string|max:100',
            'steamname' => 'required|string|max:100',
            'birthdate' => 'required|date|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $dev_role = Role::where('slug','User')->first();
        $user->roles()->attach($dev_role);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("New Token")->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function checkAuth(Request $request)
    {
        if (Auth::guard('api')->check()) {
            // Here you have access to $request->user() method that
            // contains the model of the currently authenticated user.
            //
            // Note that this method should only work if you call it
            // after an Auth::check(), because the user is set in the
            // request object by the auth component after a successful
            // authentication check/retrival
            return response()->json(true);
        }
        else {
            return response()->json(false);
        }
    }
}

