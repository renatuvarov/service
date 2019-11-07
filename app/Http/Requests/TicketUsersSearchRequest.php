<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketUsersSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'string|email|nullable',
            'name' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'surname' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'patronymic' => 'string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'phone' => 'integer|digits:10|nullable'
        ];
    }

    public function messages()
    {
        return [
            'email.string' => 'Не строка',
            'email.email' => 'Некорректный email',

            'name.string' => 'Не строка',
            'name.max' => 'Более 100 символов',
            'name.regex' => 'Некорректное имя',

            'surname.string' => 'Не строка',
            'surname.max' => 'Более 100 символов',
            'surname.regex' => 'Некорректная фамилия',

            'patronymic.string' => 'Не строка',
            'patronymic.max' => 'Более 100 символов',
            'patronymic.regex' => 'Некорректное отчество',

            'phone.integer' => 'Не число',
            'phone.digits' => 'Некорректный номер',
        ];
    }
}
