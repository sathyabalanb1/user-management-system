<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\User as UserResource;
use App\Models\PasswordResets;
use App\Notifications\PasswordRestNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\UserInterface;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error'], 400);
        }
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $response['token'] = $user->createToken('myapp')->plainTextToken;
        $response['name'] = $user->name;

        return response()->json($response, 200);
    }
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
    public function detail()
    {
        $user = Auth::user();
        return new UserResource($user);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logout successfully.']);
    }
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return new UserResource($user);
    }
    public function DeleteProfile()
    {
        $id = Auth::user()->id;
        $users = User::find($id);
        $users->delete();
        return response(['message' => 'Profile Deleted successfully.']);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        /* $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];*/
        if (isset($user)) {

            $validator = Validator::make($request->all(), [

                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation Error'], 400);
            }
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $response['token'] = $user->createToken('myapp')->plainTextToken;
            $response['name'] = $user->name;
            //return response()->json($response, 200);
            return new UserResource($response);
        }
        return response()->json(["message" => "User cannot create"]);
    }
}
