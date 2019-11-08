@extends('layouts.basic')

@include('delete.delete')

@section('content')
    <div class="container">

        <h2 class="select_header">Пользователи</h2>

        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}

        <p class="add_ticket_wrapper">
            <a href="{{ route('admin.users.create') }}" class="add_ticket">Создать</a>
        </p>

        <div class="admin-search_show_wrapper">
            <button class="btn admin-search_show js-admin-search_show" type="button">Поиск</button>
        </div>

        <div class="admin-search_wrapper @if(count($errors) > 0) admin-search_wrapper--active @endif js-admin-search_wrapper">
            <form action="{{ route('admin.users.index') }}"
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
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="email"></button>
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
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="name"></button>
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
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="surname"></button>
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
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="patronymic"></button>
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
                    <button class="clear_value js-clear_value"
                            type="button"
                            data-name="phone"></button>
                </div>
                <div class="form-input_group js-select_element_wrapper">
                    <ul class="select_element-list js-select_element">
                        <li class="select_element-item select_element-selected js-select_element-selected">
                            Все роли
                        </li>
                        <li class="select_element-item js-select_element-item select_element-current"
                            data-role="all">Все роли</li>
                        @foreach($roles as $role)
                            <li class="select_element-item js-select_element-item" data-role="{{ $role }}">
                                Только {{ $role === 'admin' ? 'админы' : 'пользователи' }}
                            </li>
                        @endforeach
                    </ul>
                    <select name="role" class="select_element-hidden js-select_element-hidden">
                        <option value="" data-role="all" selected></option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" data-role="{{ $role }}"></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-input_group js-checkbox">
                    <div class="checkbox-toggle_status">
                        <span class="checkbox-txt">Email подтвержден</span>
                        <div class="checkbox-btn js-checkbox-btn"></div>
                    </div>
                    <input type="checkbox" name="verified" class="checkbox-hidden js-checkbox-hidden">
                </div>
                <div class="admin-search_form_btn_wrapper">
                    <button type="submit" class="btn btn--submit">Найти</button>
                </div>
                <button class="admin-search_form_close js-admin-search_form_close" type="button"></button>
            </form>
        </div>

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
