<?php

namespace App\Services;

use App\Repositories\Interfaces\FormRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FormService
{

    public function __construct(
        protected FormRepositoryInterface   $formRepositoryInterface,
        protected QuestionnaireService      $questionnaireService,
    ){}

    public function create($form)
    {
        try {
            $persistForm = $this->formRepositoryInterface->create($form);

            if ($persistForm['status'] != 1) {
                throw new \Exception($persistForm['message']);
            }

            $this->questionnaireService->createQuestionnaire($persistForm['id'], $form->questionnaire);

            return response()->json([
                'message' => 'Form created successfully',
                'uuid' => $persistForm['uuid'],
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        try {

            $showForm = $this->formRepositoryInterface->show($uuid);

            if ($showForm['status'] != 1) {
                throw new \Exception($showForm['message']);
            }

            $showQuestionnaire = $this->questionnaireService->getById($showForm['data']->id);

            return response()->json([
                'data' => [
                    $showForm['data'],
                    'questionnaire' => $showQuestionnaire,
                ],
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                    'message' => $e->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
        }
    }


}
