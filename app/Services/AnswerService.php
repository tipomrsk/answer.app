<?php

namespace App\Services;

use App\Repositories\Interfaces\AnswerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AnswerService
{

    public function __construct(
        protected AnswerRepositoryInterface $answerRepositoryInterface
    ){}

    public function create($answerData): JsonResponse
    {
        try {
            foreach ($answerData->answers as $answer) {
                $massArray[] = [
                    'hash_identifier' => $answerData->hash_identifier,
                    'form_uuid' => $answer['form_uuid'],
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                ];
            }

            $persistAnswer = $this->answerRepositoryInterface->create($massArray);

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

    public function show(string $formUuid): JsonResponse
    {
        try {

            $showAnswer = $this->answerRepositoryInterface->show($formUuid);

            if ($showAnswer['status'] != 1) {
                throw new \Exception($showAnswer['message']);
            }

            return response()->json([
                'data' => $showAnswer['data'],
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
