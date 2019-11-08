@component('mail::message')
    # Вы пропустили отправление.

    Вы пропустили маршрут {{ $ticket['departure_point'] }} - {{$ticket['arrival_point']}},
    отправляющийся {{ date('d.m.Y', strtotime($ticket['date'])) }} в {{ substr($ticket['time'], 0, -3) }}.

    Пожалуйста, свяжитесь с администрацией.

    С уважением,
    {{ config('app.name') }}
@endcomponent
