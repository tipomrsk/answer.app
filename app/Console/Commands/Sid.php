<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class Sid extends Command
{
    protected $signature = 'sid';

    protected $description = 'Esse comando é responsável por popular o banco com alguns milhões de registros.';

    private string $formUuid;

    private string $questionId;




    public function handle()
    {
        $this->createFormAndQuestions();

        $this->createRecordsInBatches(Answer::class, 2000000);

        $this->info('All records created successfully.');
    }

    /**
     * Deixei esse método bem genérico para que possa ser utilizado em qualquer model
     *
     * Ele é responsável por fazer um mass insert por lotes para ser performático e aliviar a memória
     *
     * @param $modelClass
     * @param $totalRecords
     * @return void
     */
    private function createRecordsInBatches($modelClass, $totalRecords)
    {
        $this->info('Creating records for Answer...');

        $batchSize = 1000; // Tamanho do lote, aqui da pra brincar com o valor para ver o impacto na performance
        $remainingRecords = $totalRecords;

        /**
         * Iniciando as variáveis para o primeiro lote
         */
        $this->questionId = 1;
        $this->formUuid = Question::find($this->questionId)->form_uuid;

        /**
         * o método insert() do eloquent não define o timestamp automaticamente
         */
        $timestamp = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Iniciando um contador que não vai zerar no for e com isso a cada 10k vai trocar os ids de questions e form
        $startValue = 0;

        // Iteração dos lotes
        while ($remainingRecords > 0) {
            $batchRecords = min($batchSize, $remainingRecords);
            $data = [];

            // Preparação dos lotes
            for ($i = 0; $i < $batchRecords; $i++) {

                // A cada múltiplo de 10k, troca o id da question e do form
                if ($startValue > 0 && $startValue % 10000 === 0) {
                    $this->questionId++;
                    $this->formUuid = Question::find($this->questionId)->form_uuid;
                }

                // Montagem dos dados
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
     * Esse aqui eu separei só pra ficar mais simples o método createRecordsInBatches()
     * Outra coisa também é que mesmo sendo "só 400 persistencias", usei o insert() e não o create()
     * Para performar melhor e não ter que fazer 400 conexões no banco
     *
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

        $this->info('Creating records for Forms...');
        Form::insert($formData);

        $this->info('Creating records for Questions...');
        Question::insert($questionData);
    }
}
