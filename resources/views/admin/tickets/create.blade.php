@extends('layouts.basic')

@include('calendar.calendar')
@include('time.time')

@section('content')
    <div class="container">
        <h2 class="select_header">Создать маршрут</h2>
        <form action="{{ route('admin.tickets.store') }}" method="post" class="form">
            @csrf
            <div class="form-input_group @error('date') is-invalid @enderror">
                <p class="form-input js-input js-select_date">{{ date('d.m.Y', strtotime(old('date', $calendar->currentDay->format('d.m.Y')))) }}</p>
                @error('date')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden"
                   value="{{ old('date', $calendar->currentDay->format('Y-m-d')) }}"
                   class="js-form-hidden_input"
                   name="date">
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
            </div>
            <div class="form-input_group @error('time') is-invalid @enderror">
                <p class="form-input js-input js-select_time">{{ substr(old('time', date('H:i:s')), 0, -3) }}</p>
                @error('time')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden"
                   value="{{ old('time', date('H:i:s')) }}"
                   class="js-form-hidden_time"
                   name="time">
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
            </div>
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Создать</button>
                </div>
            </div>
        </form>
    </div>
@endsection