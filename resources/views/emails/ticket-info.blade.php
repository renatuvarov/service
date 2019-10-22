@component('mail::message')
    # Информация

    Информация по маршруту {{$ticket->departurePoint()}} - {{$ticket->arrivalPoint()}},
    отправляющегося {{ $ticket->date->format('d.m.Y') }} в {{ substr($ticket->time, 0, -3) }}:
    {{ $message }}

    С уважением,
    {{ config('app.name') }}
@endcomponent