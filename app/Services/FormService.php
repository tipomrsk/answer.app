<?php

namespace App\Services;

use App\Data\FormData;
use App\Repositories\Interfaces\FormRepositoryInterface;

class FormService
{

    public function __construct(
        protected FormRepositoryInterface $formRepositoryInterface
    ){}

    public function create(FormData $form)
    {
        return $this->formRepositoryInterface->create($form->exceptQuestionnaire());
    }

    public function show($uuid)
    {
        return $this->formRepositoryInterface->show($uuid);
    }


}
