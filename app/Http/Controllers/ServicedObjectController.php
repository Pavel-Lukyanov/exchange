<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateObjectRequest;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Organization;
use App\Models\ServicedObject;
use App\Services\ServicedObjectService;
use App\Transformers\ServicedObjectTransformer;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $userId = auth()->user()->getAuthIdentifier();
        $organization = Organization::query()->where('user_id', $userId);
        $validatedData = $request->validated();

        DB::tansaction(function () use ($validatedData, $organization) {
            $object = new ServicedObject;
            $object->fill($validatedData);
            $object->save();

            $contract = new Contract();
            $contract->fill(['serviced_object_id'=> $object->id, 'organization_id' => $organization->id]);
            $contract->save();
        });

        return response()->json(['message' => 'Object created successfully'], 201);
    }

    public function delete(Request $request, int $objectId)
    {
        $object = ServicedObject::findOrFail($objectId);

        $customers = $object->customers;

        foreach ($customers as $customer) {
            $customersSearch = Customer::query()->where('user_id', $customer->user_id)->get()->toArray();

            if(count($customersSearch) === 1) {
               User::findOrFail($customer->user_id)->update(['deleted_at' => Carbon::now()]);
            }
        }
        $object->update(['is_archived' => 1]);
        return response()->json(['message' => 'Object deleted successfully'], 201);
    }
}
