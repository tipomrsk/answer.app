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

            throw new \Exception($message);

        }

    }

    public function show(string $uuid)
    {
        try {
            return $this->model->select('name', 'email', 'range_limit', 'count_limit')->where('uuid', $uuid)->firstOrFail();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception('User not found');
        }
    }

    public function updateLimit(string $form_uuid)
    {
        try {
            $user = $this->model->select('users.id', 'count_limit')
                ->join('forms', 'users.id', 'forms.user_id')
                ->where('forms.uuid', $form_uuid)
                ->firstOrFail();

            if (!$user) {
                throw new \Exception('Error to get user limit');
            }

            $user->count_limit = $user->count_limit + 1;
            $user->save();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to update user limit');
        }

    }

    public function checkLimit(string $formUuid)
    {
        try {
            $user = $this->model->select('range_limit', 'count_limit')
                ->join('forms', 'users.id', 'forms.user_id')
                ->where('forms.uuid', $formUuid)
                ->firstOrFail();

            if ($user->count_limit >= $user->range_limit) {
                throw new \Exception('User limit reached');
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('User limit reached');
        }
    }


}
