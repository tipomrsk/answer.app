<?php

namespace App\Http\Controllers;

use App\Services\FormService;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function __construct(
        protected FormService $formService
    ){}

    public function create()
    {

        return $this->formService->create();

    }
}
