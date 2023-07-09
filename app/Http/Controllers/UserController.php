<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }
}
