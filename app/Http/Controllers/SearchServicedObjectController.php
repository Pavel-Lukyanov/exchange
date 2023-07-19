<?php

namespace App\Http\Controllers;

use App\Services\ServicedObjectService;
use App\Transformers\ServicedObjectTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;


class SearchServicedObjectController extends Controller
{
    private ServicedObjectTransformer $objectTransformer;
    private ServicedObjectService $objectService;
    public function __construct(ServicedObjectService $objectService, ServicedObjectTransformer $objectTransformer)
    {
        $this->objectService = $objectService;
        $this->objectTransformer = $objectTransformer;
    }
    public function search(Request $request)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $objects = $this->objectService->searchObjects($request->all(), $userId);

        $data = fractal()
            ->collection($objects)
            ->transformWith($this->objectTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($objects))
            ->withResourceName('search_serviced_objects')
            ->toArray();

        return response()->json($data);
    }
}
