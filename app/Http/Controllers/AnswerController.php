<?php

namespace App\Http\Controllers;

use App\Data\AnswerData;
use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct(
        protected AnswerService $answerService,
    ){}

    public function create(AnswerData $answerData)
    {
        return $this->answerService->create($answerData);
    }
}
