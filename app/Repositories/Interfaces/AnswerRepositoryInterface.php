<?php

namespace App\Repositories\Interfaces;

interface AnswerRepositoryInterface
{
    public function create(array $answerData);

    public function show(string $formUuid);

}
