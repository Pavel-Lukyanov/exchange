<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateObjectRequest;
use App\Models\ServicedObject;
use App\Services\ServicedObjectService;
use App\Transformers\ServicedObjectTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;

class ServicedObjectController extends Controller
{
    private ServicedObjectTransformer $objectTransformer;
    private ServicedObjectService $objectService;

    public function __construct(ServicedObjectService $objectService, ServicedObjectTransformer $objectTransformer)
    {
        $this->objectService = $objectService;
        $this->objectTransformer = $objectTransformer;
    }

    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
		$objects = $this->objectService->index($request->all(), $userId);

        $data = fractal()
            ->collection($objects)
            ->transformWith($this->objectTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($objects))
            ->withResourceName('serviced_objects')
            ->toArray();

        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function showObject($id): JsonResponse
    {
        $object = $this->objectService->showObject($id);

        $data = fractal()
            ->item($object)
            ->transformWith($this->objectTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('serviced_object')
            ->toArray();

        return response()->json($data);
    }

    public function create(CreateObjectRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $data['is_archived'] = false;
        $data['is_completed'] = true;

        $object = new ServicedObject;
        $object->fill($validatedData);
        $object->save();

        return response()->json(['message' => 'Object created successfully'], 201);
    }
}
