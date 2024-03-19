<?php

namespace App\Repositories\Interfaces;

interface QuestionnaireRepositoryInterface
{
    public function create(array $questionnaire);

    public function getById(int $id);

    public function getLastQuestion(string $form_uuid);
}
