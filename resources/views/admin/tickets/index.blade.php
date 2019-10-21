@extends('layouts.basic')

@section('content')
    <div class="container">

        <h2 class="select_header">Маршруты</h2>

        {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}

        <p class="add_ticket_wrapper">
            <a href="{{ route('admin.tickets.create') }}" class="add_ticket">Создать</a>
        </p>

        @if($tickets->count() > 0)
            <div class="table-wrapper">
                <table class="table table-admin">
                    <thead class="table-head">
                    <tr class="table-head_row">
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Места</th>
                        <th colspan="3">Управление</th>
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
                            <td><a class="table-show" href="{{ route('admin.tickets.show', ['ticket' => $ticket->id]) }}">Просмотр</a></td>
                            <td><a class="table-edit" href="{{ route('admin.tickets.edit', ['ticket' => $ticket->id]) }}">Редактировать</a></td>
                            <td><a class="table-remove" href="{{ route('admin.tickets.remove', ['ticket' => $ticket->id]) }}">Удалить</a></td>
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
                        <td colspan="3">Управление</td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <p class="add_ticket_wrapper">
                <a href="{{ route('admin.tickets.create') }}" class="add_ticket">Создать</a>
            </p>

            {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}

        @else
            <p class="ticket-info">Билетов не найдено</p>
        @endif
    </div>
@endsection
