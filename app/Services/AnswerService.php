<?php

namespace App\Services;

use App\Repositories\Interfaces\AnswerRepositoryInterface;
use Illuminate\Http\Response;

class AnswerService
{

    public function __construct(
        protected AnswerRepositoryInterface $answerRepositoryInterface
    ){}

    public function create($answerData)
    {
        try {
            $persistAnswer = $this->answerRepositoryInterface->create($answerData);

            if ($persistAnswer['status'] != 1) {
                throw new \Exception($persistAnswer['message']);
            }

            return response()->json([
                'message' => 'Answer created successfully'
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
