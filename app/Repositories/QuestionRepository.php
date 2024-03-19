<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;
use Illuminate\Support\Facades\Log;

class QuestionRepository implements QuestionnaireRepositoryInterface
{

    public function __construct(
        protected Question $model
    ){}

    /**
     * Cria uma nova pergunta
     *
     * @param array $questionnaire
     * @return string[]
     * @throws \Exception
     */
    public function create(array $questionnaire)
    {
        try {

            $this->model->insert($questionnaire);

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            throw new \Exception('Error to create question');
        }
    }

    /**
     * Busca as perguntas pelo id do formulário
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getById(int $id)
    {
        try {
            return $this->model->select('id', 'form_id', 'question', 'type', 'options')->where('form_id', $id)->get();

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to get questionnaire');
        }
    }
}
