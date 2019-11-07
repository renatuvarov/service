<div class="calendar js-calendar">
    <div class="calendar-body">
        <div class="calendar-month_name_list">
            @foreach($calendar->months as $key => $month)
                <h3 class="calendar-header js-calendar_header" data-monthname="{{ $key }}">{{ $calendar->monthNames[$key] }} {{ date('Y') }}</h3>
            @endforeach
            <button data-direction="prev" class="calendar-select_month_btn calendar-select_month_btn--prev js-calendar-select_month_btn"></button>
            <button data-direction="next" class="calendar-select_month_btn calendar-select_month_btn--next js-calendar-select_month_btn"></button>
        </div>
        <ul class="calendar-month">
            <li class="calendar-day">Пн</li>
            <li class="calendar-day">Вт</li>
            <li class="calendar-day">Ср</li>
            <li class="calendar-day">Чт</li>
            <li class="calendar-day">Пт</li>
            <li class="calendar-day">Сб</li>
            <li class="calendar-day">Вс</li>

        </ul>
        <ul class="calendar-months_list">
            @foreach($calendar->months as $key => $month)
                <li class="calendar-month_item js-calendar-month_item" data-month="{{ $key }}">
                    @foreach($month as $week)
                        <ul class="calendar-week">
                            @foreach($week as $day)
                                <li class="calendar-day js-calendar-day">
                                    @if($calendar->currentDay->format('Y-m-d') <= $day->format('Y-m-d') && $calendar->currentDay->format('Y') == $day->format('Y'))
                                        <button type="button"
                                                class="calendar-select{{
                                            $calendar->currentDay->format('Y-m-d') == $day->format('Y-m-d') ? ' calendar-selected' : ''
                                        }}{{
                                            $key == $day->format('m') ? '' : ' calendar-next'
                                        }} js-calendar-select"
                                                data-date="{{ $day->format('Y-m-d') }}">
                                            {{$day->day}}
                                        </button>
                                    @else
                                        <button type="button" class="calendar-select calendar-inactive">{{$day->day}}</button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </li>
            @endforeach
        </ul>
        <button type="button" class="calendar-close js-calendar-close"></button>
        <button type="button" class="calendar-set_day js-calendar-set_day">Выбрать</button>
    </div>
</div>