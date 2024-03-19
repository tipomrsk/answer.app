<?php

beforeEach(function () {
    $this->user = [
        "name" => "Mateus Bougleux",
        "email" => Faker\Factory::create()->email(),
        "password" => "12345678",
        "range_limit" => 100,
    ];
});


it('should create a user and return 201', function () {
    $this->postJson('/api/user/create', $this->user)
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'uuid',
        ])
        ->assertJsonCount(2);
});

it('should return 422 when try to create a user with invalid email', function () {
    $this->user['email'] = 'invalid';

    $this->postJson('/api/user/create', $this->user)
        ->assertStatus(422)
        ->assertJson([
            "message"=> "The email field must be a valid email address.",
            "errors" => [
                "email" => [
                    "The email field must be a valid email address."
                ]
            ]
        ])
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email'
            ],
        ])
        ->assertJsonCount(2);
});

it('should return 422 when try to create a user with invalid email and password', function () {
    $this->user['email'] = 'invalid';
    $this->user['password'] = '123';

    $this->postJson('/api/user/create', $this->user)
        ->assertStatus(422)
        ->assertJson([
            "message"=> "The email field must be a valid email address. (and 1 more error)",
            "errors" => [
                "email" => [
                    "The email field must be a valid email address."
                ],
                "password" => [
                    "The password field must have at least 8 digits."
                ]
            ]
        ])
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'password'
            ],
        ])
        ->assertJsonCount(2);
});

it('should return 400 when try to create a user with an email that already exists', function () {
    $this->postJson('/api/user/create', $this->user);

    $this->postJson('/api/user/create', $this->user)
        ->assertStatus(400)
        ->assertJson([
            "message"=> "Email {$this->user['email']} already exists"
        ])
        ->assertJsonStructure([
            'message',
        ])
        ->assertJsonCount(1);
});

it('shloud return 422 when try to create a user with an invalid password', function () {
    $this->user['password'] = '123';

    $this->postJson('/api/user/create', $this->user)
        ->assertStatus(422)
        ->assertJson([
            "message"=> "The password field must have at least 8 digits.",
            "errors" => [
                "password" => [
                    "The password field must have at least 8 digits."
                ]
            ]
        ])
        ->assertJsonStructure([
            'message',
            'errors' => [
                'password'
            ],
        ])
        ->assertJsonCount(2);
});
