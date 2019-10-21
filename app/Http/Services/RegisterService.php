<?php

namespace App\Http\Services;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function createUser(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_USER,
        ]);

        event(new Registered($user));

        Auth::login($user);
    }
}