<?php

namespace App\Repositories\Interfaces;

interface AnswerRepositoryInterface
{
    public function create(array $answerData);

    public function show(string $formUuid);

    public function getAnswersAndQuestions(string $hash_identifier);

}
