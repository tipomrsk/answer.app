<?php

namespace App\Http\Controllers;

use App\Data\FormData;
use App\Services\FormService;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function __construct(
        protected FormService $formService
    ){}

    public function create(FormData $formData)
    {
        return $this->formService->create($formData);
    }

    public function show($uuid)
    {
        return $this->formService->show($uuid);
    }
}
