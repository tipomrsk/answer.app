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

    /**
     * Cria um novo formulário
     *
     * @param $form
     * @return array
     * @throws Exception
     */
    public function create($form)
    {
        try {
            return $this->model->create($form->toArray());
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception('Error to create form');

        }
    }

    /**
     * Retorna um formulário pelo uuid
     *
     * @param string $uuid
     * @return mixed
     * @throws Exception
     */
    public function show(string $uuid)
    {
        try {
            return $this->model->select('id', 'uuid', 'name', 'description', 'style', 'webhook_url')->where('uuid', $uuid)->firstOrFail();

        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception('Form not found');
        }
    }

}
