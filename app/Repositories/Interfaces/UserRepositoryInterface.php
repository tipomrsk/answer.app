<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function create(array $userData);

    public function show(string $uuid);

    public function updateLimit(string $form_uuid);

    public function checkLimit(string $formUuid);

    public function notifyUser(string $form_uuid);
}
