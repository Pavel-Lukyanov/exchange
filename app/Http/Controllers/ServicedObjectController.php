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
    public function index(): JsonResponse
    {
       $objects = ServicedObject::all();
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
