<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\{Email, MinDigits};
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public function __construct(

        public string|Optional $uuid,

        public string $name,

        #[Email]
        public string $email,

        #[MinDigits(8)]
        public string $password,

        public int $range_limit,

        public int|Optional $count_limit,

    ){}

}
