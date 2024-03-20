<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\{Url, Json, Uuid};
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class FormData extends Data
{
    public function __construct(

        #[Uuid]
        public string|Optional $uuid,

        public int $user_id,

        public string $name,

        public string $description,

        #[Json]
        public string $style,

        #[Url]
        public string|Optional $webhook_url,

        public array|Optional $questionnaire

    ){}

    public function exceptQuestionnaire(): Collection
    {
        return collect($this->toArray())->except('questionnaire');
    }

}
