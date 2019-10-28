@component('mail::message')
# Смена пароля

Для смены пароля перейдите по ссылке ниже.

@component('mail::button', ['url' => route('reset.form', ['id' => $id, 'token' => $token])])
    Перейти
@endcomponent

С уважением,
{{ config('app.name') }}
@endcomponent