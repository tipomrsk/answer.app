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
