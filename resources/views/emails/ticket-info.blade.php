@component('mail::message')
    # Информация

    Информация по маршруту {{
        $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->departure_point;})->city_name
     }} - {{
        $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->arrival_point;})->city_name
      }}, отправляющегося {{ $ticket->date->format('d.m.Y') }} в {{ substr($ticket->time, 0, -3) }}:
    {{ $message }}

    С уважением,
    {{ config('app.name') }}
@endcomponent