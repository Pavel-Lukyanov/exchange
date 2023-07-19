<?php

namespace App\Services;

use App\Models\ServicedObject;

class ServicedObjectService
{
    public function index($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ServicedObject::getObjects($data, $userId);
    }

    public function showObject($id)
    {
        return ServicedObject::findOrFail($id);
    }

    public function searchObjects($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ServicedObject::searchObjects($data, $userId);
    }

    public function createObject($data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data['user_id'] = $userId;

        return ServicedObject::createObject($data);
    }

}
