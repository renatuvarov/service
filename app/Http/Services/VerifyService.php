<?php

namespace App\Http\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyService
{
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('user.home');
        }

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->input('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    }
}