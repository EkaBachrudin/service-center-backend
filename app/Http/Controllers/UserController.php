<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Counter;

class UserController extends Controller
{
    public function userProfile() {
        return response()->json(auth()->user());
    }

    public function userRoles() {
        return response()->json(auth()->user()->roles);
    }

    public function getAllUsers(){
        $users = User::latest()->get();
        return response()->json([
            'message' => 'Success get all users',
            'data' => $users
        ]);
    }

    public function getAllUserByCounter($id){
        $data  = Counter::find($id);
        $user = $data->users;

        return response()->json([
            'message' => 'Success Get All User by Counter',
            'data' => $user,
        ]);
    }
}
