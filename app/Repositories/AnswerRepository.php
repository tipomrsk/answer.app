<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Repositories\Interfaces\AnswerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AnswerRepository implements AnswerRepositoryInterface
{

    public function __construct(
        protected Answer $model
    ){}

    public function create(array $answerData)
    {
        try {

            $this->model->insert($answerData);

            return [
                'status' => 1,
                'message' => 'Answer created successfully'
            ];

        }catch (\Exception $e) {
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }
    }

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
                $returnArray[$answer['hash_identifier']]['questions'][] = [
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
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }
    }
}
