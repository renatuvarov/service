@component('mail::message')
    # Маршрут отменен

    К сожалению, маршрут {{ $ticket['departure_point'] }} - {{$ticket['arrival_point']}},
    отправляющийся {{ date('d.m.Y', strtotime($ticket['date'])) }} в {{ substr($ticket['time'], 0, -3) }} отменен.

    Приносим свои извенения.

    С уважением,
    {{ config('app.name') }}
@endcomponent
