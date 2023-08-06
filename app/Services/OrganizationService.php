<?php

namespace App\Services;


use App\Models\Organization;

class OrganizationService
{
    public function index($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Organization::getOrganizations($data, $userId);
    }

    public function show($userId, $id)
    {
        return Organization::show($userId, $id);
    }
}
