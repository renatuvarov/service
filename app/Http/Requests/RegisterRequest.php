<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:255', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Это поле обязательно для заполнения',
            'email.string' => 'Значение этого поля должно быть строкой',
            'email.email' => 'Некорректный адрес электронной почты',
            'email.max' => 'Значение поля не должно превышать 255 символов',
            'email.unique' => 'Пользователь с таким :email уже существует',

            'password.required' => 'Это поле обязательно для заполнения',
            'password.string' => 'Значение этого поля должно быть строкой',
            'password.min' => 'Значение поля должно быть не короче 8 символов',
            'password.max' => 'Значение поля не должно превышать 255 символов',

            'password_confirmation.required' => 'Это поле обязательно для заполнения',
            'password_confirmation.string' => 'Значение этого поля должно быть строкой',
            'password_confirmation.min' => 'Значение поля должно быть не короче 8 символов',
            'password_confirmation.max' => 'Значение поля не должно превышать 255 символов',
            'password_confirmation.same' => 'Пароли должны совпадать',
        ];
    }
}
