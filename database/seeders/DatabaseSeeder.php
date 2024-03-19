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

        User::factory(1)->create([
            'email' => 'teste@teste.com',
            'range_limit' => 100,
            'count_limit' => 98,
            'uuid' => 'k2k2k2k2-2k2k-2k2k-2k2k-2k2k2k2k2k2k',
        ]);

        Form::factory(1)->create([
            'name' => 'Form 1',
            'description' => 'Form 1 description',
            'style' => '{}',
            'uuid' => 'd3e3e3e3-3e3e-3e3e-3e3e-3e3e3e3e3e3e',
            'user_id' => 3
        ]);

        Question::factory(10)->create([
            'form_uuid' => 'd3e3e3e3-3e3e-3e3e-3e3e-3e3e3e3e3e3e'
        ]);

        $form = Form::factory(5)->create();

        $form->each(function (Form $f) {
            $question = Question::factory()->count(10)->create(['form_uuid' => $f->uuid]);

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
