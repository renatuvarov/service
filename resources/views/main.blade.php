@extends('layouts.basic')

@include('calendar.calendar')

@section('content')
    <div class="container">
        <h2 class="select_header">Выбрать маршрут</h2>
        <form action="{{ route('tickets.index') }}" method="get" class="form">
            <div class="form-input_group @error('date') is-invalid @enderror">
                <p class="form-input js-input js-select_date">{{ date('d.m.Y', strtotime(old('date', $currentDay->format('d.m.Y')))) }}</p>
                @error('date')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden"
                   value="{{ old('date', $currentDay->format('Y-m-d')) }}"
                   class="js-form-hidden_input"
                   name="date">
            <div class="form-input_group js-form-input_group @error('departure_point') is-invalid @enderror">
                <input type="text"
                       name="departure_point"
                       id="departure_point js-input"
                       class="form-input js-input js-form-search_city"
                       placeholder="Место отправления"
                       autofocus
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
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Поиск</button>
                </div>
            </div>
        </form>
    </div>
@endsection