<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganizationRequest;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\ServicedObject;
use App\Models\User;
use App\Services\OrganizationService;
use App\Transformers\OrganizationTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;

class OrganizationController extends Controller
{
    private OrganizationTransformer $organizationTransformer;
    private OrganizationService $organizationService;

    public function __construct(OrganizationTransformer $organizationTransformer, OrganizationService $organizationService)
    {
        $this->organizationTransformer = $organizationTransformer;
        $this->organizationService = $organizationService;
    }
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->user()->getAuthIdentifier();

        $organizations = $this->organizationService->index($request->all(), $userId);

        $data = fractal()
            ->collection($organizations)
            ->transformWith($this->organizationTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($organizations))
            ->withResourceName('organizations')
            ->toArray();

        return response()->json($data);
    }

    public function create(CreateOrganizationRequest $request)
    {
        $userId = auth()->user()->getAuthIdentifier();

        $validatedData = $request->validated();

        $validatedData['user_id'] = $userId;
        $organization = new Organization();
        $organization->fill($validatedData);
        $organization->save();

        return response()->json(['message' => 'Организация успешно создана'], 201);
    }

    public function showOrganization(OrganizationService $organizationService, $id): JsonResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
        $organization = $this->organizationService->show($userId, $id);

        $data = fractal()
            ->item($organization)
            ->transformWith($this->organizationTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('organization')
            ->toArray();

        return response()->json($data);
    }

    public function delete(Request $request, int $organizationId)
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();

            $organization = Organization::findOrFail($organizationId);


            if ($organization->deleted_at != null) {
                return response()->json(['message' => 'Организация не найдена'], 404);
            }

            if ($organization->user_id != $userId) {
                return response()->json(['message' => 'Вы не являетесь владельцем этой организации'], 403);
            }

            DB::transaction(function () use ($organization) {
                $employees = $organization->employees;

                //Удаляем employees у которых 1 объект
                foreach ($employees as $employee) {
                    $organizationsOfEmployee = Employee::where('user_id', $employee->user_id)
                        ->where('deleted_at', null)
                        ->pluck('organization_id')
                        ->toArray();

                    if (count(array_unique($organizationsOfEmployee)) === 1) {
                        Employee::where('user_id', $employee->user_id)
                            ->update(['deleted_at' => Carbon::now()]);

                        User::where('id', $employee->user_id)
                            ->update(['deleted_at' => Carbon::now()]);
                    }
                }

                //Удаляем контракты
                Contract::where('organization_id', $organization->id)
                    ->update(['deleted_at' => Carbon::now()]);

                //Удаляем организации
                $contracts = Contract::where('organization_id', $organization->id)->get();

                foreach ($contracts as $contract) {
                    $servicedObjects = ServicedObject::where('contract_id', $contract->id)->get();

                    foreach ($servicedObjects as $servicedObject) {
                        $servicedObject->update(['deleted_at' => Carbon::now()]);
                    }
                }

                $organization->update(['deleted_at' => Carbon::now()]);
            });

            return response()->json(['message' => 'Организация успешно удалена'], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Организация не найдена'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
