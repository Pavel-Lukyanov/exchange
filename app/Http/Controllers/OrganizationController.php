<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganizationRequest;
use App\Models\Employees;
use App\Models\Organization;
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

        return response()->json(['message' => 'Organization created successfully'], 201);
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

            if ($organization->user_id != $userId) {
                return response()->json(['message' => 'You are not the owner of this organization'], 403);
            }

            DB::transaction(function () use ($organization) {
                $employees = $organization->employees;

                foreach ($employees as $employee) {
                    $employeesSearch = Employees::where('user_id', $employee->user_id)
                        ->where('organization_id', '!=', $employee->organization_id)
                        ->count();

                    if($employeesSearch === 0) {
                        Employees::where('user_id', $employee->user_id)->update(['deleted_at' => Carbon::now()]);
                    }
                }

                $organization->update(['deleted_at' => Carbon::now()]);
            });

            return response()->json(['message' => 'Organization deleted successfully'], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Organization not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the organization'], 500);
        }
    }
}
