<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class SeedDatabase extends Command
{
    protected $signature = 'seed';

    protected $description = 'Seed the database';

    private string $formUuid;

    private string $questionId;




    public function handle()
    {
        $this->info('Creating Form and Questions...');
        $this->createFormAndQuestions();

        $this->info('Creating records for Answer...');
        $this->createRecordsInBatches(Answer::class, 2000000);

        $this->info('All records created successfully.');
    }

    private function createRecordsInBatches($modelClass, $totalRecords)
    {
        $batchSize = 1000;
        $remainingRecords = $totalRecords;

        $this->questionId = 1;
        $this->formUuid = Question::find($this->questionId)->form_uuid;

        $timestamp = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $startValue = 0;

        while ($remainingRecords > 0) {
            $batchRecords = min($batchSize, $remainingRecords);
            $data = [];

            for ($i = 0; $i < $batchRecords; $i++) {

                if ($startValue > 0 && $startValue % 10000 === 0) {
                    $this->questionId++;
                    $this->formUuid = Question::find($this->questionId)->form_uuid;
                }

                $data[] = [
                        'question_id' => $this->questionId,
                        'form_uuid' => $this->formUuid,
                        'hash_identifier' => '88888888-3e3e-3e3e-3e3e-111111111111',
                        'answer' => 'Answer ' . ($i + 1)
                    ] + $timestamp;

                $startValue++;
            }

            $modelClass::insert($data);

            $remainingRecords -= $batchRecords;
        }
    }


    /**
     * @param $i
     * @return void
     */
    public function createFormAndQuestions(): void
    {

        $timestamp = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for($i = 0; $i < 200; $i++) {

            $this->formUuid = Uuid::uuid4();

            $formData[] = [
                'name' => 'Form ' . ($i + 1),
                'description' => 'Form ' . ($i + 1) . ' description',
                'style' => '{}',
                'uuid' => $this->formUuid,
                'webhook_url' => 'http://localhost:8000/api/form/webhook',
                'user_id' => 3,
            ] + $timestamp;

            $questionData[] = [
                'form_uuid' => $this->formUuid,
                'question' => 'Question 1',
                'type' => 'text',
                'options' => '{}',
            ] + $timestamp;
        }

        Form::insert($formData);

        Question::insert($questionData);
    }
}
