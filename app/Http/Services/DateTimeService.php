<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;

class DateTimeService
{
    public function __construct()
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
    }

    public function months()
    {
        return [
            1=>"Январь",
            2=>"Февраль",
            3=>"Март",
            4=>"Апрель",
            5=>"Май",
            6=>"Июнь",
            7=>"Июль",
            8=>"Август",
            9=>"Сентябрь",
            10=>"Октябрь",
            11=>"Ноябрь",
            12=>"Декабрь"
        ];
    }

    public function monthsFromCurrent()
    {
        return array_filter($this->months(), function ($key) {
            return $key >= (int) date('m');
        }, ARRAY_FILTER_USE_KEY);
    }

    public function allMonth()
    {
        $months = [];
        $keys = range(Carbon::now()->month, 12);

        foreach ($keys as $month) {
            $months[] = $this->getMonth($month);
        }

        return array_combine($keys, $months);
    }

    private function getMonth(int $currentMonth): array
    {
        $start = Carbon::createFromDate(null, $currentMonth, 1)->startOfMonth()->modify('monday this week');
        $end = Carbon::createFromDate(null, $currentMonth, 1)->endOfMonth()->modify('sunday this week');
        $period = CarbonPeriod::create($start, $end)->toArray();
        return array_chunk($period, 7);
    }
}