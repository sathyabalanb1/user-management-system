<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;


class ProfileController extends Controller
{
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
}
