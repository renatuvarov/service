@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Введите свой email</h2>
        <form action="{{ route('forgot.email') }}" method="post" class="form">
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
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Отправить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
