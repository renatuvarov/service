<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Это поле обязательно для заполнения',
            'email.string' => 'Значение этого поля должно быть строкой',
            'email.email' => 'Некорректный адрес электронной почты',

            'password.required' => 'Это поле обязательно для заполнения',
            'password.string' => 'Значение этого поля должно быть строкой',
        ];
    }
}
