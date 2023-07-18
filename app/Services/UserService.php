<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function index(): \Illuminate\Database\Eloquent\Collection|array
    {
        return User::all();
    }

    public function showUser($id)
    {
        return User::findOrFail($id);
    }
}
