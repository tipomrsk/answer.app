<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        $form = Form::factory(10)->create();

        $form->each(function (Form $f) {
            Question::factory()->count(7)->create(
                [
                    'form_id' => $f->id
                ]
            );
        });
    }
}
