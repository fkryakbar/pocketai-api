<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response([
            'status' => 'success',
            'token' => $user->createToken('access_token')->plainTextToken
        ]);
    }

    public function user(Request $request)
    {
        return response([
            'status' => 'success',
            'user_session' => $request->user()
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'status' => 'success',
            'message' => 'Token successfully revoked'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $hashed_password = bcrypt($request->password);

        $request->merge(['password' => $hashed_password]);

        $user =  User::create($request->all());

        return response($user);
    }
}
