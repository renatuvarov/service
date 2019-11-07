@extends('layouts.basic')

@include('delete.delete')
@include('calendar.calendar')
@include('time.time')

@section('content')
    <div class="container">

        <h2 class="select_header">Маршруты</h2>

        {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}

        <p class="add_ticket_wrapper">
            <a href="{{ route('admin.tickets.create') }}" class="add_ticket">Создать</a>
        </p>

        <div class="admin-search_show_wrapper">
            <button class="btn admin-search_show js-admin-search_show" type="button">Поиск</button>
        </div>

        <div class="admin-search_wrapper @if(count($errors) > 0) admin-search_wrapper--active @endif js-admin-search_wrapper">
            <form action="{{ route('admin.tickets.index') }}"
                  class="admin-search_form js-admin-search_form" method="post">
                @csrf
                <div class="form-input_group @error('date') is-invalid @enderror">
                    <p class="form-input js-input js-select_date">{{ date('d.m.Y', strtotime(old('date', $calendar->currentDay->format('d.m.Y')))) }}</p>
                    @error('date')
                    <p class="form-error_message">{{ $message }}</p>
                    @enderror
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="date"></button>
                </div>
                <input type="hidden"
                       value="{{ old('date', $calendar->currentDay->format('Y-m-d')) }}"
                       class="js-form-hidden_input"
                       name="date">
                <div class="form-input_group @error('time') is-invalid @enderror">
                    <p class="form-input js-input js-select_time">{{ substr(old('time', date('H:i:s')), 0, -3) }}</p>
                    @error('time')
                    <p class="form-error_message">{{ $message }}</p>
                    @enderror
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="time"></button>
                </div>
                <input type="hidden"
                       value="{{ old('time', date('H:i:s')) }}"
                       class="js-form-hidden_time"
                       name="time">
                <div class="form-input_group js-form-input_group @error('departure_point') is-invalid @enderror">
                    <input type="text"
                           name="departure_point"
                           id="departure_point"
                           class="form-input js-input js-form-search_city"
                           placeholder="Место отправления"
                           value="{{ old('departure_point') }}">
                    <ul class="form-city_list js-form-city_list">
                    </ul>
                    @error('departure_point')
                    <p class="form-error_message">{{ $message }}</p>
                    @enderror
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="departure_point"></button>
                </div>
                <div class="form-input_group js-form-input_group @error('arrival_point') is-invalid @enderror">
                    <input type="text"
                           name="arrival_point"
                           id="arrival_point"
                           class="form-input js-input js-form-search_city"
                           placeholder="Место прибытия"
                           value="{{ old('arrival_point') }}">
                    <ul class="form-city_list js-form-city_list"></ul>
                    @error('arrival_point')
                    <p class="form-error_message">{{ $message }}</p>
                    @enderror
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="arrival_point"></button>
                </div>
                <div class="form-input_group @error('seats') is-invalid @enderror">
                    <input type="number"
                           class="form-input js-input"
                           name="seats"
                           value="{{ old('seats') }}" placeholder="Места"
                           min="5"
                           max="50">
                    @error('seats')
                    <p class="form-error_message">{{ $message }}</p>
                    @enderror
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="seats"></button>
                </div>
                <div class="admin-search_form_btn_wrapper">
                    <button type="submit" class="btn btn--submit">Найти</button>
                </div>
                <button class="admin-search_form_close js-admin-search_form_close" type="button"></button>
            </form>
        </div>

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
                            <td data-label="Откуда">{{ $ticket->departurePoint() }}</td>
                            <td data-label="Куда">{{ $ticket->arrivalPoint() }}</td>
                            <td data-label="Дата">{{ $ticket->date->format('d.m.Y') }}</td>
                            <td data-label="Время">{{ date('H:i', strtotime($ticket->time)) }}</td>
                            <td data-label="Места">{{ $ticket->seat }}</td>
                            <td><a class="table-show" href="{{ route('admin.tickets.show', ['ticket' => $ticket->id]) }}">Просмотр</a></td>
                            <td><a class="table-edit" href="{{ route('admin.tickets.edit', ['ticket' => $ticket->id]) }}">Редактировать</a></td>
                            <td><a class="table-remove js-table-remove" data-url="{{ route('admin.tickets.destroy', ['ticket' => $ticket->id]) }}">Удалить</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Места</th>
                        <th colspan="3">Управление</th>
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
