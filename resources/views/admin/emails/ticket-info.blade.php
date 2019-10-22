@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Письмо для {{ $user ? $user->email : 'для всех' }}</h2>
        <form action="{{ route('admin.email.send', ['ticket' => $ticket->id, 'id' => $user->id ?? '']) }}" method="post" class="form">
            @csrf
            <div class="form-input_group js-form-input_group @error('message') is-invalid @enderror">
                <input type="text"
                       name="message"
                       class="form-input js-input"
                       placeholder="Текст сообщения"
                       value="{{ old('message') }}">
                @error('message')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
                <div class="form-input_group">
                    <button type="submit" class="btn btn--submit">Отправить</button>
                </div>
            </div>
        </form>
    </div>
@endsection