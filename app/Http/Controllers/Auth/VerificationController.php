<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\VerifyService;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    /**
     * @var VerifyService
     */
    private $service;

    public function __construct(VerifyService $service)
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->service = $service;
    }

    public function verify(Request $request)
    {
        $this->service->verify($request);
        return redirect()->route('user.home')->with('verified', true);
    }

    public function resend()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user.home');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
