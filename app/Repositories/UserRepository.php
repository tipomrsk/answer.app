<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        protected User $model,
    ){}

    public function create(array $userData): array
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

            $message = 'Failed to create user';

            if($e->getCode() == 23000) {
                $message = "Email {$userData['email']} already exists";
            }

            Log::error($e->getMessage());

            return [
                'message' => $message,
                'status' => 0
            ];

        }

    }

    public function show(string $uuid): array
    {
        try {
            $user = $this->model->select('name', 'email', 'range_limit', 'count_limit')->where('uuid', $uuid)->firstOrFail();

            if (!$user) {
                throw new \Exception('User not found');
            }

            return [
                'data' => $user,
                'status' => 1
            ];
        }
        catch (\Exception $e) {

            Log::error($e->getMessage());

            return [
                'message' => 'User not found',
                'status' => 0
            ];
        }
    }
}
