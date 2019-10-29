@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Создать аккаунт</h2>
        <form action="{{ route('admin.users.store') }}" method="post" class="form">
            @csrf
            <div class="form-input_group @error('email') is-invalid @enderror">
                <input type="text"
                       class="form-input js-input"
                       name="email"
                       placeholder="Email"
                       value="{{old('email')}}">
                @error('email')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group @error('password') is-invalid @enderror">
                <input type="password"
                       name="password"
                       class="form-input js-input"
                       placeholder="Пароль">
                @error('password')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group @error('password_confirmation') is-invalid @enderror">
                <input type="password"
                       name="password_confirmation"
                       class="form-input js-input"
                       placeholder="Повторите пароль">
                @error('password_confirmation')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Создать</button>
                </div>
            </div>
        </form>
    </div>
@endsection
