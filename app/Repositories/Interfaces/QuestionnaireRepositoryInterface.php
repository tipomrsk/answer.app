<?php

namespace App\Repositories\Interfaces;

interface QuestionnaireRepositoryInterface
{
    public function create(array $questionnaire);

    public function getById(int $id);
}
