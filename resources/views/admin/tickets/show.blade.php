@extends('layouts.basic')

@section('content')
    <h2 class="select_header">Маршрут</h2>
    <table class="table table-admin">
        <thead class="table-head">
        <tr class="table-head_row">
            <th>Откуда</th>
            <th>Куда</th>
            <th>Дата</th>
            <th>Время</th>
            <th>Места</th>
            <th colspan="2">Управление</th>
        </tr>
        </thead>
        <tbody class="table-body">
            <tr>
                <td data-label="Откуда">{{ $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->departure_point;})->city_name }}</td>
                <td data-label="Куда">{{ $ticket->cities->first(function($item) use ($ticket) {return $item->id == $ticket->arrival_point;})->city_name }}</td>
                <td data-label="Дата">{{ $ticket->date->format('d.m.Y') }}</td>
                <td data-label="Время">{{ date('H:i', strtotime($ticket->time)) }}</td>
                <td data-label="Места">{{ $ticket->seat }}</td>
                <td><a class="table-edit" href="{{ route('admin.tickets.edit', ['ticket' => $ticket->id]) }}">Редактировать</a></td>
                <td><a class="table-remove" href="{{ route('admin.tickets.remove', ['ticket' => $ticket->id]) }}">Удалить</a></td>
            </tr>
        </tbody>
    </table>
    <h2 class="select_header">Пассажиры</h2>

    {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

    <table class="table">
        <thead class="table-head">
        <tr class="table-head_row">
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Телефон</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody class="table-body">
        @foreach($users as $user)
            <tr>
                <td data-label="Фамилия">{{ $user->pivot->surname }}</td>
                <td data-label="Имя">{{ $user->pivot->name }}</td>
                <td data-label="Отчество">{{ $user->pivot->patronymic }}</td>
                <td><a class="table-edit" href="tel:{{ $user->pivot->phone }}">{{ $user->pivot->phone }}</a></td>
                <td><a class="table-edit" href="{{ route('admin.email', ['id' => $user->id]) }}">{{ $user->email }}</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Телефон</th>
            <th>Email</th>
        </tr>
        </tfoot>
    </table>

    {{ $users->appends(request()->input())->links('vendor.pagination.default') }}
@endsection