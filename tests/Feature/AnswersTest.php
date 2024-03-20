<?php

use App\Models\User;

beforeEach(function () {
    $this->answer = [
        "hash_identifier" => "b7ac1920-384f-4531-8265-b2b564e1fbcf",
        "form_uuid" => "d3e3e3e3-3e3e-3e3e-3e3e-3e3e3e3e3e3e",
        "answers" => [
            [
                "question_id" => 1,
                "answer" => "Mateus Bougleux"
            ],
            [
                "question_id" => 2,
                "answer" => "29/09/1997"
            ],
            [
                "question_id" => 3,
                "answer" => "Laranja, Manga"
            ],
            [
                "question_id" => 4,
                "answer" => "Cabeda"
            ],
            [
                "question_id" => 5,
                "answer" => "Sim"
            ],
            [
                "question_id" => 6,
                "answer" => "Sim"
            ],
            [
                "question_id" => 7,
                "answer" => "Sim"
            ],
            [
                "question_id" => 8,
                "answer" => "Sim"
            ],
            [
                "question_id" => 9,
                "answer" => "Sim"
            ],
            [
                "question_id" => 10,
                "answer" => "Sim"
            ]
        ]
    ];
});

it('should return 201 when try to create an answer', function () {

    User::where('id', 3)->update(['count_limit' => 90]);

    $this->postJson('/api/answer/create', $this->answer)
        ->assertStatus(201)
        ->assertJsonStructure([
            'message'
        ])
        ->assertJsonCount(1);
});

it('should return 422 when try to create an answer with invalid form_uuid', function () {
    $this->answer['form_uuid'] = 'invalid';

    $this->postJson('/api/answer/create', $this->answer)
        ->assertStatus(400)
        ->assertJson([
            "message"=> "Please, check the form_uuid"
        ])
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonCount(1);
});

it('should return 400 when try to creante an answer because user has reached the limit', function () {

    User::where('id', 3)->update(['count_limit' => 100]);

    $this->postJson('/api/answer/create', $this->answer)
        ->assertStatus(400)
        ->assertJson([
            "message"=> "User limit reached"
        ])
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonCount(1);
});

it('should return 200 when try to show an answer', function () {
    $this->get('/api/answer/list-by-form/d3e3e3e3-3e3e-3e3e-3e3e-3e3e3e3e3e3e')
        ->assertStatus(200)
        ->assertJsonCount(1);
});


it('should return 400 when try to show an answer with invalid uuid', function () {
    $this->get('/api/answer/list-by-form/invalid')
        ->assertStatus(400)
        ->assertJson([
            "message"=> "Error to get answers"
        ])
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonCount(1);
});
