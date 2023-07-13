<?php

namespace App\Http\Controllers;

use App\Models\ServicedObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicedObjectController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->user()->id;
        $objects = ServicedObject::query()->where('user_id', $userId)->first();
//        $employees = $objects->employees;
//        $employeeIds = [];
//        foreach ($employees as $employee) {
//            $employeeIds[] = $employee->user_id;
//        }
//        $objects = ServicedObject::query()->whereIn('user_id', $employeeIds)->get();

        return response()->json($objects);
    }

    /**
     * @return JsonResponse
     */
    public function showObject($id): JsonResponse
    {
        $object = ServicedObject::findOrFail($id);

        return response()->json($object);
    }
}
