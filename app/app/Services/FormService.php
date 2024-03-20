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

    /**
     * Cria o formulário e o questionário
     *
     * @param $form
     * @return JsonResponse
     */
    public function create($form)
    {
        try {
            $persistForm = $this->formRepositoryInterface->create($form);

            $this->questionnaireService->createQuestionnaire($persistForm->uuid, $form->questionnaire);

            return response()->json([
                'message' => 'Form created successfully',
                'uuid' => $persistForm->uuid,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna o forumlário e o questionário
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        try {

            $showForm = $this->formRepositoryInterface->show($uuid);

            $showQuestionnaire = $this->questionnaireService->getByUuid($showForm->uuid);

            return response()->json([
                'data' => [
                    'form' => $showForm,
                    'questionnaire' => $showQuestionnaire,
                ],
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listByUser(string $user_uuid)
    {
        try {
            return response()->json([
                'data' => $this->formRepositoryInterface->listByUser($user_uuid),
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
