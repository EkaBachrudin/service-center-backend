<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
