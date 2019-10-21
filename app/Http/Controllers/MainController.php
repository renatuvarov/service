<?php

namespace App\Http\Controllers;

use App\Http\Services\DateTimeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    private $service;

    public function __construct(DateTimeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $months = $this->service->allMonth();
        $monthNames = $this->service->monthsFromCurrent();
        $currentDay = Carbon::now();
        $user = Auth::user();
        return view('main', compact('user', 'months', 'currentDay', 'monthNames'));
    }
}
