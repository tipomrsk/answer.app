<?php

namespace App\Repositories\Interfaces;

interface AnswerRepositoryInterface
{
    public function create($answerData);

    public function show(string $formUuid);

}
