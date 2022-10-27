<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $response['token'] = $user->createToken('myapp')->plainTextToken;
            $response['name'] = $user->name;

            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Invalid Credentials Error'], 400);
        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logout successfully.']);
    }
}
