@extends('layouts.basic')

@section('content')
    <div class="container">
        <h2 class="select_header">Редактировать профиль</h2>
        <form action="{{ route('user.profile.update') }}" class="form" method="post">
            @csrf
            @method('put')
            <div class="form-input_group js-form-input_group @error('name') is-invalid @enderror">
                <input type="text"
                       name="name"
                       class="form-input js-input"
                       placeholder="Имя"
                       value="{{ old('name', $user->name ?? '') }}">
                </ul>
                @error('name')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('surname') is-invalid @enderror">
                <input type="text"
                       name="surname"
                       class="form-input js-input"
                       placeholder="Фамилия"
                       value="{{ old('surname', $user->surname ?? '') }}">
                </ul>
                @error('surname')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('patronymic') is-invalid @enderror">
                <input type="text"
                       name="patronymic"
                       class="form-input js-input"
                       placeholder="Отчество"
                       value="{{ old('patronymic', $user->patronymic ?? '') }}">
                </ul>
                @error('patronymic')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group js-form-input_group @error('phone') is-invalid @enderror">
                <input type="number"
                       name="phone"
                       class="form-input js-input"
                       placeholder="Телефон без +7 или 8 в начале"
                       value="{{ old('phone', substr($user->phone, 2) ?? '') }}">
                </ul>
                @error('phone')
                    <p class="form-error_message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input_group">
                <div class="form-btn_wrapper">
                    <button type="submit" class="btn btn--submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection