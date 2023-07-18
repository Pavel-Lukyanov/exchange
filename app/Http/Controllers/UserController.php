<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Transformers\UserMainInfoTransformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Serializer\JsonApiSerializer;

class UserController extends Controller
{

    private UserService $userService;
    private UserMainInfoTransformer $userMainInfoTransformer;

    public function __construct(UserService $userService, UserMainInfoTransformer $userMainInfoTransformer)
    {
        $this->userService = $userService;
        $this->userMainInfoTransformer = $userMainInfoTransformer;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->index();

        $data = fractal()
            ->collection($users)
            ->transformWith($this->userMainInfoTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName('users')
            ->toArray();

        return response()->json($users);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function showUser($id): JsonResponse
    {
        $user = $this->userService->showUser($id);

        return response()->json($user);
    }
}
