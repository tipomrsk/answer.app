<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Repositories\Interfaces\AnswerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnswerRepository implements AnswerRepositoryInterface
{
    public function __construct(
        protected Answer $model
    ){}

    /**
     * Cria uma nova resposta
     *
     * @param array $answerData
     * @return array
     * @throws \Exception
     */
    public function create(array $answerData)
    {
        try {

            $this->model->insert($answerData);

            return [
                'status' => 1,
                'message' => 'Answer created successfully'
            ];

        }catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception('Error to create answer');
        }
    }

    /**
     * Retorna as respostas pelo uuid do formulário
     *
     * @param string $formUuid
     * @return array
     * @throws \Exception
     */
    public function show(string $formUuid)
    {
        try {
            $showAnswer = $this->model->select(
                DB::raw("DENSE_RANK() OVER (ORDER BY questions.id) AS question_number"),
                'answers.hash_identifier',
                'questions.id',
                'questions.question',
                'questions.type',
                'questions.options',
                'answers.answer'
            )
            ->join('forms', 'answers.form_uuid', 'forms.uuid')
            ->join('questions', 'answers.question_id', 'questions.id')
            ->where('answers.form_uuid', $formUuid)
            ->get()
            ->toArray();

            foreach ($showAnswer as $answer) {
                $returnArray[$answer['hash_identifier']]["Question {$answer['question_number']}"][] = [
                    'question_number' => $answer['question_number'],
                    'question' => $answer['question'],
                    'type' => $answer['type'],
                    'options' => $answer['options'],
                    'answer' => $answer['answer']
                ];
            }

            return [
                'status' => 1,
                'data' => $returnArray
            ];

        }catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \Exception('Error to get answers');
        }
    }
}
