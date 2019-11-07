<?php

namespace App\Http\Controllers;

use App\Http\Services\CalendarService;

class MainController extends Controller
{
    private $service;

    public function __construct(CalendarService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $calendar = $this->service->calendar();
        return view('main', compact('calendar'));
    }
}
