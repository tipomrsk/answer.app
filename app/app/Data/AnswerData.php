<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AnswerData extends Data
{

    public function __construct(

        public string $hash_identifier,

        public string $form_uuid,

        public array $answers,
    ){}
}
