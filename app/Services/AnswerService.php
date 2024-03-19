<?php

namespace App\Services;

use App\Repositories\Interfaces\AnswerRepositoryInterface;
use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AnswerService
{

    public function __construct(
        protected AnswerRepositoryInterface         $answerRepositoryInterface,
        protected UserRepositoryInterface           $userRepositoryInterface,
        protected QuestionnaireRepositoryInterface  $questionnaireRepositoryInterface,
        protected UserService                       $userService
    ){}


    /**
     * Cria a reposta no formulário
     *
     * @param $answerData
     * @return JsonResponse
     */
    public function create($answerData): JsonResponse
    {
        try {

            $this->checkLimit($answerData->form_uuid);

            $answeredQuestions = [];

            foreach ($answerData->answers as $answer) {
                $massArray[] = [
                    'hash_identifier' => $answerData->hash_identifier,
                    'form_uuid' => $answerData->form_uuid,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $answeredQuestions[] = $answer['question_id'];
            }

            $this->answerRepositoryInterface->create($massArray);

            $this->checkLastAnswerAndNotify($answerData->form_uuid, $answeredQuestions);

            return response()->json([
                'message' => 'Answer created successfully'
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna as respostas do formulário
     *
     * @param string $formUuid
     * @return JsonResponse
     */
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

    /**
     * Verifica se o usuario ainda pode receber respostas no formulário
     *
     * @param string $formUuid
     * @return void
     * @throws \Exception
     */
    public function checkLimit(string $formUuid)
    {
        try {
            $this->userRepositoryInterface->updateLimit($formUuid);

            $this->userRepositoryInterface->checkLimit($formUuid);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function checkLastAnswerAndNotify(string $form_uuid, array $answeredQuestions)
    {

        $getLastQuestion = $this->questionnaireRepositoryInterface->getLastQuestion($form_uuid);

        // if $getLastQuestion existis inside $answeredQuestions, notify the user
        if (in_array($getLastQuestion, $answeredQuestions))
            $this->userRepositoryInterface->notifyUser($form_uuid);

    }
}
