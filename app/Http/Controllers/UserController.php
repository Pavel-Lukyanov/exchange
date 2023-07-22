<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private UserService $userService;
    private UserTransformer $userTransformer;

    public function __construct(UserService $userService, UserTransformer $userTransformer)
    {
        $this->userService = $userService;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->index();

        $data = fractal()
            ->collection($users)
            ->transformWith($this->userTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('users')
            ->paginateWith(new IlluminatePaginatorAdapter($users))
            ->toArray();

        return response()->json($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function showUser($id): JsonResponse
    {
        $user = $this->userService->showUser($id);

        $data = fractal()
            ->item($user)
            ->transformWith($this->userTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('user')
            ->toArray();

        return response()->json($data);
    }

    public function search(Request $request): JsonResponse
    {
        $users = $this->userService->searchUsers($request->all());

        $data = fractal()
            ->collection($users)
            ->transformWith($this->userTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('users')
            ->paginateWith(new IlluminatePaginatorAdapter($users))
            ->toArray();

        return response()->json($data);
    }
}
