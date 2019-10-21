@extends('layouts.basic')

@section('content')
    <h2 class="select_header">Админ</h2>
    <a class="admin-info" href="{{ route('admin.tickets.index') }}">Билеты</a>
    <a class="admin-info" href="{{ route('admin.users.index') }}">Пользователи</a>
@endsection