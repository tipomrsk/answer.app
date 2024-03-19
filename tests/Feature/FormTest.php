<?php
beforeEach(function () {
    $this->form = [
        "name" => "Teste",
        "description" => "Descriação",
        "webhook_url" => "https://webhook.site/UUID",
        "style" => "{}",
        "user_id" => 1,
        "questionnaire" => [
            [
                "question" => "Qual o seu nome?",
                "type" => "string",
                "options" => []
            ],
            [
                "question" => "Quando você nasceu?",
                "type" => "date",
                "options" => []
            ],
            [
                "question" => "Quais as suas frutas favoritas?",
                "type" => "select",
                "options" => [
                    "laranja",
                    "pera",
                    "maçã",
                    "manga",
                    "limão",
                    "banana",
                    "kiwi"

                ]
            ],
            [
                "question" => "Qual seu endereço?",
                "type" => "string",
                "options" => []
            ]
        ]
    ];
});

it('shoul create a form and return status 201', function () {

    $this->form['style'] = '{"background": "#000"}';

    $this->postJson('/api/form/create', $this->form)
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'uuid'
        ])
        ->assertJsonCount(2);
});

it('should return status 422 when creating a form with invalid data', function () {

    $this->form['style'] = 'invalid';

    $this->postJson('/api/form/create', $this->form)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'style'
            ]
        ])
        ->assertJsonCount(2);
});

it('should return 400 when try to creat a form and back return with an error', function () {

    $this->form['user_id'] = 0;

    $this->postJson('/api/form/create', $this->form)
        ->assertStatus(400)
        ->assertJsonStructure([
            'message'
        ])
        ->assertJsonCount(1);
});


it('should return 200 when try to show a form', function () {

    $this->get('/api/form/show/d3e3e3e3-3e3e-3e3e-3e3e-3e3e3e3e3e3e')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'form' => [
                    'id',
                    'uuid',
                    'name',
                    'description',
                    'style',
                    'webhook_url'
                ],
                'questionnaire' => [
                    '*' => [
                        'id',
                        'question',
                        'type',
                        'options'
                    ]
                ]
            ]
        ])
        ->assertJsonCount(1);
});

it('should return 400 when try to show a form and back return with an error', function () {

    $this->get('/api/form/show/invalid')
        ->assertStatus(400)
        ->assertJsonStructure([
            'message'
        ])
        ->assertJsonCount(1);
});

it('it should list all forms by user', function () {

    $this->get('/api/form/list-by-user/k2k2k2k2-2k2k-2k2k-2k2k-2k2k2k2k2k2k')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'description',
                    'style',
                    'webhook_url'
                ]
            ]
        ])
        ->assertJsonCount(1);
});

