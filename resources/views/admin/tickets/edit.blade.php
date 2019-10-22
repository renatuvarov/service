@extends('layouts.basic')

@include('time.time')

@section('content')
    <div class="container">
        <h2 class="select_header">Изменить время</h2>
        <form action="{{ route('admin.tickets.update', ['ticket' => $ticket->id]) }}" method="post" class="form">
            @csrf
            @method('put')
            <div class="form-input_group @error('time') is-invalid @enderror">
                <p class="form-input js-input js-select_time">{{ substr(old('time', $ticket->time), 0, -3) }}</p>
                @error('time')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden"
                   value="{{ old('time', $ticket->time) }}"
                   class="js-form-hidden_time"
                   name="time">
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection