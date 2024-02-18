<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');

        $validateUser = Validator::make($input, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        try {
            if(!$token = Auth::attempt($input)){
                return response()->json([
                    'status' => false,
                    'message' => 'invalid credentials',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'error token'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $token,
            'user' => auth()->user()
        ], 200);
    }
    
    public function me()
    {
        return response()->json(auth()->user());
    }


    public function register(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'erros' => $validateUser->errors()
            ], 401);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'error creating user',
                'erros' => $th
            ], 401);
        }

        event(new Registered($user));

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $user
        ], 200);
    }
}
