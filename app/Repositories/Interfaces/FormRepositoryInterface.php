<?php

namespace App\Repositories\Interfaces;

interface FormRepositoryInterface
{

    public function create($form);

    public function show(string $uuid);
}
