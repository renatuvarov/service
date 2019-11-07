<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUsersSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'surname' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'patronymic' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'email' => 'nullable|string|email|exists:users',
            'phone' => 'integer|digits:10|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Значение этого поля должно быть строкой',
            'name.max' => 'Значение поля не должно превышать 100 символов',
            'name.regex' => 'Некорректное имя',

            'surname.string' => 'Значение этого поля должно быть строкой',
            'surname.max' => 'Значение поля не должно превышать 100 символов',
            'surname.regex' => 'Некорректная фамилия',

            'patronymic.string' => 'Значение этого поля должно быть строкой',
            'patronymic.max' => 'Значение поля не должно превышать 100 символов',
            'patronymic.regex' => 'Некорректное отчество',

            'email.string' => 'Значение этого поля должно быть строкой',
            'email.email' => 'Некорректный адрес электронной почты',
            'email.exists' => 'Пользователь с таким email не найден',

            'phone.integer' => 'Значение должно быть целым положительным числом числом',
            'phone.digits' => 'Некорректный номер',
        ];
    }
}
