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
    public function createQuestionnaire($uuid, $questionnaire)
    {

        try {

            foreach ($questionnaire as $question) {
                $massArray[] = [
                    'form_uuid' => $uuid,
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
     * @param string $uuid
     * @return mixed
     */
    public function getByUuid(string $uuid)
    {
        return $this->questionnaireRepositoryInterface->getByUuid($uuid);
    }



}
