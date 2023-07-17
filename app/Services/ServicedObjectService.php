<?php

namespace App\Services;

use App\Models\ServicedObject;

class ServicedObjectService
{
    public function index($userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return ServicedObject::getObjects($userId);
    }
}
