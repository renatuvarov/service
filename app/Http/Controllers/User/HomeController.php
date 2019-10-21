<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tickets = $user->tickets()->with('cities')->orderBy('date')->orderBy('time')->paginate(2);
        return view('user.home', compact('user', 'tickets'));
    }
}
