<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketInfoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message' => 'required|string|min:10'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'Это поле обязательно для заполнения',
            'message.string' => 'Значение поля должно быть строкой',
            'message.min' => 'Значение поля должно быть не короче 10 символов',
        ];
    }
}
