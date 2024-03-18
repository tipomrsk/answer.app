<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Repositories\Interfaces\AnswerRepositoryInterface;

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

            dd($e->getMessage());
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }
    }

    public function show(string $formUuid)
    {
        try {
            $showAnswer = $this->model->where('form_uuid', $formUuid)->get();

            return [
                'status' => 1,
                'data' => $showAnswer
            ];

        }catch (\Exception $e) {
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }
    }
}
