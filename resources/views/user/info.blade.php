@if(is_null($user->email_verified_at))
    <div class="profile-info">
        <p class="profile-info_message">Только пользователи с подтвержденным email адресом могут совершать заказы<br>
            <a class="profile-info_message_link" href="{{ route('verification.resend') }}">Отправить письмо для подтверждения email</a>
        </p>
    </div>
@endif
@if(! $user->name || ! $user->surname || ! $user->patronymic || ! $user->phone)
    <div class="profile-info">
        <p class="profile-info_message">Только пользователи с заполненным профилем могут совершать заказы<br>
            <a href="{{ route('user.profile.edit') }}" class="profile-info_message_link">Редактировать профиль</a>
        </p>
    </div>
@endif