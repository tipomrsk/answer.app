<?php

namespace App\Services;

use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;

class QuestionnaireService
{

    public function __construct(
        protected QuestionnaireRepositoryInterface $questionnaireRepositoryInterface
    ){}

    public function createQuestionnaire($id, $questionnaire): array
    {

        try {

            foreach ($questionnaire as $question) {
                $massArray[] = [
                    'form_id' => $id,
                    'question' => $question['question'],
                    'type' => $question['type'],
                    'options' => json_encode($question['options']),
                ];
            }

            $persistReturn = $this->questionnaireRepositoryInterface->create($massArray);

            if ($persistReturn['status'] != 1) {
                throw new \Exception($persistReturn['message']);
            }

            return [
                'message' => 'Questionnaire created',
                'status' => '1',
            ];

        } catch (\Exception $e) {
            return [
                'message' => 'Questionnaire not created',
                'status' => '0',
            ];
        }
    }

    public function getById(int $id)
    {
        return $this->questionnaireRepositoryInterface->getById($id);
    }



}
