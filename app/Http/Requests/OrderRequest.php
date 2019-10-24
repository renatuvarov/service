<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'surname' => 'required|string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'patronymic' => 'required|string|max:100|nullable|regex:/^[a-zA-Zа-яА-ЯЁё]+$/u',
            'phone' => 'required|integer|digits:10|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Это поле обязательно для заполнения',
            'name.string' => 'Значение этого поля должно быть строкой',
            'name.max' => 'Значение поля не должно превышать 100 символов',
            'name.regex' => 'Некорректное имя',

            'surname.required' => 'Это поле обязательно для заполнения',
            'surname.string' => 'Значение этого поля должно быть строкой',
            'surname.max' => 'Значение поля не должно превышать 100 символов',
            'surname.regex' => 'Некорректная фамилия',

            'patronymic.required' => 'Это поле обязательно для заполнения',
            'patronymic.string' => 'Значение этого поля должно быть строкой',
            'patronymic.max' => 'Значение поля не должно превышать 100 символов',
            'patronymic.regex' => 'Некорректное отчество',

            'phone.required' => 'Это поле обязательно для заполнения',
            'phone.integer' => 'Значение должно быть целым положительным числом числом',
            'phone.digits' => 'Некорректный номер',
        ];
    }
}
