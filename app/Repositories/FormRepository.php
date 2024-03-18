<?php

namespace App\Repositories;

use App\Models\Form;
use App\Repositories\Interfaces\FormRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FormRepository implements FormRepositoryInterface
{

    public function __construct(
        protected Form $model
    ){}

    public function create($form)
    {
        try {

            $this->model->create($form->toArray());

            return response()->json([
                'message' => 'Form created successfully',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Form not created',
            ], Response::HTTP_BAD_REQUEST);

        }
    }

    public function show(string $uuid): JsonResponse
    {
        try {

            return response()->json([
                'data' => $this->model->where('uuid', $uuid)->firstOrFail(),
            ], Response::HTTP_OK );

        } catch (Exception $e) {

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Form not found',
            ], Response::HTTP_NOT_FOUND);
        }
    }

}
