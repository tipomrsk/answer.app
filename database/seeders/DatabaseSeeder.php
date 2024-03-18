<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        $form = Form::factory(5)->create();

        $form->each(function (Form $f) {
            $question = Question::factory()->count(10)->create(['form_id' => $f->id]);

            $question->each(function (Question $q) use ($f) {
                $hash_identifier = Uuid::uuid4();
                Answer::factory(2)->create([
                    'question_id' => $q->id,
                    'form_uuid' => $f->uuid,
                    'hash_identifier' => $hash_identifier
                ]);
            });
        });
    }

}
