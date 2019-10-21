@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Профиль</h2>

        @include('user.info')

        <div class="profile">
            <p class="profile-item{{ is_null($user->email_verified_at) ?  ' profile-item--empty' : '' }}">
                <span class="profile-title">Статус: </span>
                {{ is_null($user->email_verified_at) ?  'Email не подтвержден' : 'Email подтвержден' }}
            </p>
            <p class="profile-item">
                <span class="profile-title">Email: </span>{{ $user->email }}
            </p>
            <p class="profile-item{{ is_null($user->name) ?  ' profile-item--empty' : '' }}">
                <span class="profile-title">Имя: </span>{{ $user->name ?? 'не заполнено' }}
            </p>
            <p class="profile-item{{ is_null($user->surname) ?  ' profile-item--empty' : '' }}">
                <span class="profile-title">Фамилия: </span>{{ $user->surname ?? 'не заполнено' }}
            </p>
            <p class="profile-item{{ is_null($user->patronymic) ?  ' profile-item--empty' : '' }}">
                <span class="profile-title">Отчество: </span>{{ $user->patronymic ?? 'не заполнено' }}
            </p>
            <p class="profile-item{{ is_null($user->phone) ?  ' profile-item--empty' : '' }}">
                <span class="profile-title">Телефон: </span>{{ $user->phone ?? 'не заполнено' }}
            </p>
            <div class="profile-btn_wrapper">
                <a class="profile-btn" href="{{ route('user.profile.edit') }}">Редактировать</a>
            </div>
        </div>
    </div>
@endsection
