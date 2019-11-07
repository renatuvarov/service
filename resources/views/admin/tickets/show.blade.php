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

    <div class="admin-search_show_wrapper">
        <button class="btn admin-search_show js-admin-search_show" type="button">Поиск</button>
    </div>

    <div class="admin-search_wrapper @if(count($errors) > 0) admin-search_wrapper--active @endif js-admin-search_wrapper">
        <form action="{{ route('admin.tickets.show', ['ticket' => $ticket->id]) }}"
              class="admin-search_form js-admin-search_form" method="post">
            @csrf
            <div class="form-input_group js-form-input_group @error('email') is-invalid @enderror">
                <input type="text"
                       name="email"
                       class="form-input js-input"
                       placeholder="email"
                       value="{{ old('email') }}">
                @error('email')
                <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('name') is-invalid @enderror">
                <input type="text"
                       name="name"
                       class="form-input js-input"
                       placeholder="Имя"
                       value="{{ old('name') }}">
                @error('name')
                <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('surname') is-invalid @enderror">
                <input type="text"
                       name="surname"
                       class="form-input js-input"
                       placeholder="Фамилия"
                       value="{{ old('surname') }}">
                @error('surname')
                <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('patronymic') is-invalid @enderror">
                <input type="text"
                       name="patronymic"
                       class="form-input js-input"
                       placeholder="Отчество"
                       value="{{ old('patronymic') }}">
                @error('patronymic')
                <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('phone') is-invalid @enderror">
                <input type="number"
                       name="phone"
                       class="form-input js-input"
                       placeholder="Телефон без +7 или 8 в начале"
                       value="{{ old('phone') }}">
                @error('phone')
                <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-checkbox">
                <div class="checkbox-toggle_status">
                    <span class="checkbox-txt">Только отсутсвующие</span>
                    <div class="checkbox-btn js-checkbox-btn"></div>
                </div>
                <input type="checkbox" name="status" class="checkbox-hidden js-checkbox-hidden">
            </div>
            <div class="admin-search_form_btn_wrapper">
                <button type="submit" class="btn btn--submit">Найти</button>
            </div>
            <button class="admin-search_form_close js-admin-search_form_close" type="button"></button>
        </form>
    </div>

    @if($users->count() > 0)

        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

        <div class="admin-tickets_email_wrapper">
            <a href="{{ route('admin.email.new', ['ticket' => $ticket->id]) }}" class="admin-tickets_email">Сообщение для всех</a>
        </div>

        <table class="table js-table_users">
            <thead class="table-head">
            <tr class="table-head_row">
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody class="table-body">
            @foreach($users as $user)
                <tr>
                    <td data-label="Фамилия">{{ $user->pivot->surname }}</td>
                    <td data-label="Имя">{{ $user->pivot->name }}</td>
                    <td data-label="Отчество">{{ $user->pivot->patronymic }}</td>
                    <td>
                        <a class="table-show" href="tel:{{ $user->pivot->phone }}">+7{{ $user->pivot->phone }}</a>
                    </td>
                    <td>
                        <a class="table-show" href="{{ route('admin.email.new', ['ticket' => $ticket, 'id' => $user->id]) }}">{{ $user->email }}</a>
                    </td>
                    <td>
                        <button class="table-edit js-toggle_status"
                                data-link="{{ route('ajax.status', ['id' => $user->id, 'ticket' => $ticket->id]) }}"
                                type="button">{{ $user->pivot->status === 'waiting' ? 'Ожидание' : 'Прибыл' }}</button>
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
                <th>Статус</th>
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