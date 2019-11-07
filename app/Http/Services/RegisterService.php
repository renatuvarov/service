<?php

namespace App\Http\Services;

use App\Http\Services\Elasticsearch\UsersService;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * @var UsersService
     */
    private $service;

    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }

    public function createUser(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_USER,
        ]);

        $this->service->index($user);

        event(new Registered($user));

        return $user;
    }
}