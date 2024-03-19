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

    public function create(array $questionnaire)
    {
        try {
            $this->model->insert($questionnaire);

            return [
                'message' => 'Question created successfully',
                'status' => '1',
            ];

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            throw new \Exception('Error to create question');
        }
    }

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
