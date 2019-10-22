@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Билеты</h2>
        @include('user.info')
        @if($tickets->count() > 0)
            {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}
            <div class="table-wrapper">
                <table class="table">
                    <thead class="table-head">
                    <tr class="table-head_row">
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Места</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td data-label="Откуда">{{ $ticket->departurePoint() }}</td>
                            <td data-label="Куда">{{ $ticket->arrivalPoint() }}</td>
                            <td data-label="Дата">{{ $ticket->date->format('d.m.Y') }}</td>
                            <td data-label="Время">{{ date('H:i', strtotime($ticket->time)) }}</td>
                            <td data-label="Места">{{ $ticket->seat }}</td>
                            <td>
                                <form action="{{ route('tickets.remove', ['ticket' => $ticket->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="table-remove">Отменить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Места</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            {{ $tickets->appends(request()->input())->links('vendor.pagination.default') }}

        @else
            @if($user->hasFilledProfile())
                <p class="ticket-info">Вы пока не добавили билеты<br>
                    <a href="{{ route('main') }}" class="ticket-info_message_link">Найти маршруты</a>
                </p>
            @endif
        @endif
    </div>
@endsection
