@extends('layouts.basic')

@section('content')
    <div class="container">
        <p>К сожалению, все места на этом маршруте уже были заняты</p>
        <a href="{{ route('main') }}">На главную</a>
    </div>
@endsection