<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ){}

    public function create(UserData $userData)
    {
        return $this->userService->create($userData);
    }
}
