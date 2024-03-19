<?php

namespace App\Services;

use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;
use Illuminate\Support\Facades\Log;

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

            $this->questionnaireRepositoryInterface->create($massArray);

            return [
                'message' => 'Questionnaire created',
                'status' => '1',
            ];

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to create questionnaire');
        }
    }

    public function getById(int $id)
    {
        return $this->questionnaireRepositoryInterface->getById($id);
    }



}
