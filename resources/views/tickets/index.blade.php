@extends('layouts.basic')

@section('content')
    <div class="container">

        <h2 class="select_header">Маршруты</h2>

        @if($tickets->count() > 0)
            {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}
            <div class="table-wrapper">
                <table class="table">
                    <thead class="table-head">
                    <tr class="table-head_row">
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Места</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td data-label="Откуда">{{ $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->departure_point;})->city_name }}</td>
                            <td data-label="Куда">{{ $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->arrival_point;})->city_name }}</td>
                            <td data-label="Дата">{{ $ticket->date->format('d.m.Y') }}</td>
                            <td data-label="Время">{{ date('H:i', strtotime($ticket->time)) }}</td>
                            <td data-label="Места">{{ $ticket->seat }}</td>
                            <td>
                                <form action="{{ route('tickets.order', ['ticket' => $ticket->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="table-show">Заказать</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>Откуда</td>
                        <td>Куда</td>
                        <td>Дата</td>
                        <td>Время</td>
                        <td>Места</td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}
        @else
            <p class="ticket-info">Билетов не найдено<br>
                <a href="{{ route('main') }}" class="ticket-info_message_link">Найти другие маршруты</a>
            </p>
        @endif
    </div>
@endsection