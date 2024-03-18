<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Repositories\Interfaces\AnswerRepositoryInterface;

class AnswerRepository implements AnswerRepositoryInterface
{

    public function __construct(
        protected Answer $model
    ){}

    public function create($answerData)
    {

        try {
            $this->model->create($answerData->toArray());

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
}
