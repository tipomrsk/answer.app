<?php

namespace App\Services;

use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;

class QuestionnaireService
{
    public function __construct(
        protected QuestionnaireRepositoryInterface $questionnaireRepositoryInterface
    ){}

    /**
     * Persiste as perguntas do formulário
     *
     * @param $id
     * @param $questionnaire
     * @return array
     * @throws \Exception
     */
    public function createQuestionnaire($id, $questionnaire)
    {

        try {

            foreach ($questionnaire as $question) {
                $massArray[] = [
                    'form_id' => $id,
                    'question' => $question['question'],
                    'type' => $question['type'],
                    'options' => json_encode($question['options']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            $this->questionnaireRepositoryInterface->create($massArray);

        } catch (\Exception $e) {
            throw new \Exception('Error to create questionnaire');
        }
    }

    /**
     * Retorna as perguntas do formulário
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->questionnaireRepositoryInterface->getById($id);
    }



}
