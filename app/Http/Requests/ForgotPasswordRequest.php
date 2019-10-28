<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|exists:users',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Это поле обязательно для заполнения',
            'email.string' => 'Значение этого поля должно быть строкой',
            'email.email' => 'Некорректный адрес электронной почты',
            'email.exists' => 'Пользователь с таким email не найден',
        ];
    }
}
