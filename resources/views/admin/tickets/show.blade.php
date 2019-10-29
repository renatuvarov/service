@extends('layouts.basic')

@include('delete.delete')

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
                <td data-label="Откуда">{{ $ticket->departurePoint() }}</td>
                <td data-label="Куда">{{ $ticket->arrivalPoint() }}</td>
                <td data-label="Дата">{{ $ticket->date->format('d.m.Y') }}</td>
                <td data-label="Время">{{ date('H:i', strtotime($ticket->time)) }}</td>
                <td data-label="Места">{{ $ticket->seat }}</td>
                <td><a class="table-edit" href="{{ route('admin.tickets.edit', ['ticket' => $ticket->id]) }}">Редактировать</a></td>
                <td><a class="table-remove js-table-remove" data-url="{{ route('admin.tickets.destroy', ['ticket' => $ticket->id]) }}">Удалить</a></td>
            </tr>
        </tbody>
    </table>
    <h2 class="select_header">Пассажиры</h2>

    @if($users->count() > 0)

        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

        <div class="admin-tickets_email_wrapper">
            <a href="{{ route('admin.email.new', ['ticket' => $ticket->id]) }}" class="admin-tickets_email">Сообщение для всех</a>
        </div>

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
                    <td>
                        <a class="table-edit" href="tel:{{ $user->pivot->phone }}">{{ $user->pivot->phone }}</a>
                    </td>
                    <td>
                        <a class="table-edit" href="{{ route('admin.email.new', ['ticket' => $ticket, 'id' => $user->id]) }}">{{ $user->email }}</a>
                    </td>
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

        <div class="admin-tickets_email_wrapper">
            <a href="{{ route('admin.email.new', ['ticket' => $ticket->id]) }}" class="admin-tickets_email">Сообщение для всех</a>
        </div>

        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

    @else
        <p class="ticket-info">На этом маршруте пока никого нет</p>
    @endif
@endsection