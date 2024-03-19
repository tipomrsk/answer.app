<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Response;

class UserService
{

    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ){}

    public function create($userData)
    {
        try {
            $createUser = $this->userRepository->create($userData->toArray());

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

}
