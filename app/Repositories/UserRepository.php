<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        protected User $model,
    ){}

    public function create(array $userData)
    {
        try {

            $createUser = $this->model->create($userData);

            return [
                'message' => 'User created successfully',
                'uuid' => $createUser->uuid,
                'status' => 1
            ];
        }
        catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'status' => 0
            ];

        }

    }
}
