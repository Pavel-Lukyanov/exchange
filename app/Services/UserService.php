<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function index(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::paginate(config('defaults.pagination.per_page'));
    }

    public function showUser($id)
    {
        return User::findOrFail($id);
    }

    public function searchUsers($data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::searchUsers($data);
    }
}
