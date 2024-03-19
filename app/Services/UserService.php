<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Response;

class UserService
{

    public function __construct(
        protected UserRepositoryInterface $userInterfaceRepository,
    ){}

    public function create($userData)
    {
        try {
            $createUser = $this->userInterfaceRepository->create($userData->toArray());

            if ($createUser['status'] != 1) {
                throw new \Exception($createUser['message']);
            }

            return response()->json([
                'message' => 'User created successfully',
                'uuid' => $createUser['uuid']
            ], Response::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(string $uuid)
    {
        try {
            $user = $this->userInterfaceRepository->show($uuid);

            if ($user['status'] != 1) {
                throw new \Exception($user['message']);
            }

            return response()->json([
                'message' => 'User found',
                'data' => $user['data']
            ], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
