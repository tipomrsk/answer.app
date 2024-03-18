<?php

namespace App\Services;

use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;

class QuestionnaireService
{

    public function __construct(
        protected QuestionnaireRepositoryInterface $questionnaireRepositoryInterface
    ){}

    public function createQuestionnaire($id, $questionnaire)
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

            $this->questionnaireRepositoryInterface->create($massArray);

        } catch (\Exception $e) {
            return [
                'message' => 'Questionnaire not created',
                'status' => '0',
            ];
        }


    }

}
