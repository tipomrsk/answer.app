<?php

namespace App\Services;

use App\Repositories\Interfaces\FormRepositoryInterface;

class FormService
{

    public function __construct(
        protected FormRepositoryInterface $formRepositoryInterface
    ){}

    public function create($form)
    {
        return $this->formRepositoryInterface->create($form);
    }


}
