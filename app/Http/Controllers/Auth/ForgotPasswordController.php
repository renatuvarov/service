<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ForgotPassword;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.forgot');
    }

    public function sendEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        $token = sha1(Str::random(10));

        $user->update([
            'reset_password_token' => $token,
        ]);

        Mail::to($user->email)->send(new ForgotPassword($user->id, $token));

        return redirect()->route('login');
    }
}
