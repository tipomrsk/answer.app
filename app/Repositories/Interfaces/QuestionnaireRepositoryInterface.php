<?php

namespace App\Repositories\Interfaces;

interface QuestionnaireRepositoryInterface
{
    public function create(array $questionnaire);

    public function getByUuid(string $uuid);

    public function getLastQuestion(string $form_uuid);
}
