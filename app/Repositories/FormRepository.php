<?php

namespace App\Repositories;

use App\Models\Form;
use App\Repositories\Interfaces\FormRepositoryInterface;

class FormRepository implements FormRepositoryInterface
{

    public function __construct(
        protected Form $model
    ){}

    public function create($form)
    {
        dd($form);
    }

}
