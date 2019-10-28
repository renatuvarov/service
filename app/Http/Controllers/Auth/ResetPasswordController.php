<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetForm($id, $token)
    {
        $user = User::findOrFail($id);

        if ($user->reset_password_token === $token) {
            return view('auth.reset-form', compact('user'));
        }

        abort(404);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $user = User::findOrFail($request->route('id'));

        $user->update([
            'password' => Hash::make($request->input('password')),
            'reset_password_token' => null,
        ]);

        return redirect()->route('login');
    }
}
