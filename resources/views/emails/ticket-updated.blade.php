@component('mail::message')
    # Время отправления изменено

    Информация по маршруту {{$ticket->departurePoint()}} - {{$ticket->arrivalPoint()}},
    отправляющегося {{ $ticket->date->format('d.m.Y') }} в {{ substr($oldTime, 0, -3) }}:

    Время отправления изменено с {{ substr($oldTime, 0, -3) }} на {{ substr($ticket->time, 0, -3) }}.

    Приносим свои извенения.

    С уважением,
    {{ config('app.name') }}
@endcomponent
