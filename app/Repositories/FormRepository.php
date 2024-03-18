<?php

namespace App\Repositories;

use App\Models\Form;
use App\Repositories\Interfaces\FormRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class FormRepository implements FormRepositoryInterface
{
    public function __construct(
        protected Form $model
    ){}

    public function create($form)
    {
        try {
            $data = $this->model->create($form->toArray());

            return [
                'id' => $data->id,
                'uuid' => $data->uuid,
                'message' => 'Form created successfully',
                'status' => '1',
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return [
                'message' => 'Form not created',
                'status' => '0',
            ];

        }
    }

    public function show(string $uuid)
    {
        try {

            return [
                'data' => $this->model->select('id', 'uuid', 'name', 'description', 'style')->where('uuid', $uuid)->firstOrFail(),
                'status' => '1',
            ];

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return [
                'message' => 'Form not found',
                'status' => '0',
            ];
        }
    }

}
