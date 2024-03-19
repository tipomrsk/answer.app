<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Jobs\SendWHJob;
use App\Models\User;
use App\Notifications\FormFullyAnswered;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        protected User $model,
    ){}

    /**
     * Cria um novo usuário
     *
     * @param array $userData
     * @return array
     * @throws \Exception
     */
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

    /**
     * Retorna um usuário pelo uuid
     *
     * @param string $uuid
     * @return mixed
     * @throws \Exception
     */
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

    /**
     * Atualiza o limite de formulários do usuário
     *
     * @param string $form_uuid
     * @return void
     * @throws \Exception
     */
    public function updateLimit(string $form_uuid)
    {
        try {
            $user = $this->model->select('users.id', 'count_limit')
                ->join('forms', 'users.id', 'forms.user_id')
                ->where('forms.uuid', $form_uuid)
                ->firstOrFail();

            $user->count_limit = $user->count_limit + 1;
            $user->save();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to update user limit');
        }

    }

    /**
     * Verifica se o usuário ainda pode receber respostas no formulário
     *
     * @param string $formUuid
     * @return void
     * @throws \Exception
     */
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

    public function notifyUser(string $form_uuid)
    {
        $notifyData = $this->getUserDataToNotify($form_uuid);

        SendEmailJob::dispatch($notifyData->email);

        SendWHJob::dispatch($notifyData->webhook_url, $this->builWhebhookPayload(), "secret");

    }

    public function getUserDataToNotify(string $form_uuid)
    {
        try {
            return $this->model->select('email', 'webhook_url')
                ->join('forms', 'users.id', 'forms.user_id')
                ->where('forms.uuid', $form_uuid)
                ->firstOrFail();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to get user data');
        }
    }

    private function builWhebhookPayload()
    {
        return [
            "message" => "Form fully answered",
        ];
    }


}
