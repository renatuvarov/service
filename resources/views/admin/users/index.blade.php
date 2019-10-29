@extends('layouts.basic')

@include('delete.delete')

@section('content')
    <div class="container">

        <h2 class="select_header">Пользователи</h2>

        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

        <p class="add_ticket_wrapper">
            <a href="{{ route('admin.users.create') }}" class="add_ticket">Создать</a>
        </p>

        @if($users->count() > 0)
            <div class="table-wrapper">
                <table class="table table-admin">
                    <thead class="table-head">
                    <tr class="table-head_row">
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($users as $user)
                        <tr>
                            <td data-label="Фамилия">{{ $user->surname ?? '-' }}</td>
                            <td data-label="Имя">{{ $user->name ?? '-' }}</td>
                            <td data-label="Отчество">{{ $user->patronymic ?? '-' }}</td>
                            <td data-label="Email">{{ $user->email }}</td>
                            <td data-label="Телефон">{{ $user->phone ?? '-' }}</td>
                            <td data-label="Роль">{{ $user->role }}</td>
                            <td data-label="Статус">{{ $user->email_verified_at ? 'Подтвержден' : 'Не подтвержден' }}</td>
                            <td>
                                @if($id === $user->id)
                                    -
                                @else
                                    <a class="table-remove js-table-remove" data-url="{{ route('admin.users.destroy', ['user' => $user->id]) }}">Удалить</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Управление</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <p class="add_ticket_wrapper">
                <a href="{{ route('admin.users.create') }}" class="add_ticket">Создать</a>
            </p>

            {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

        @else
            <p class="ticket-info">Пользователей не найдено</p>
        @endif
    </div>
@endsection
