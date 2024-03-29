<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\UserUtil;
use Illuminate\Support\Facades\Session;

class UserController extends Controller 
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $queryParams = $request->all();

        $users = $this->userRepository->getAllUsers($queryParams);
        foreach ($users as $user) {
            $flg = $user->user_flg;
            $user->user_flg = UserUtil::getUserFlag($flg);
        }
        Session::put('oldQuery', $queryParams);

        return view('screens.user.index', ['users' => $users]);
    }

    public function store(Request $request): JsonResponse 
    {
        $userDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json(
            [
                'data' => $this->userRepository->createUser($userDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse 
    {
        $userId = $request->route('id');

        return response()->json([
            'data' => $this->userRepository->getUserById($userId)
        ]);
    }

    public function update(Request $request): JsonResponse 
    {
        $userId = $request->route('id');
        $userDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->userRepository->updateUser($userId, $userDetails)
        ]);
    }

    public function destroy(Request $request): JsonResponse 
    {
        $userId = $request->route('id');
        $this->userRepository->deleteUser($userId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}