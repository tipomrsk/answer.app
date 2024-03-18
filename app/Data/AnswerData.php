<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AnswerData extends Data
{

    public function __construct(

        public int $question_id,

        public string $form_uuid,

        public string $answer,
    ){}

}
