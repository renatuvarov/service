<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TicketUpdatedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $after = '|after:' . Carbon::now()->format('H:i:s');

        return [
            'time' => 'required|date_format:H:i:s' . $after,
        ];
    }

    public function messages()
    {
        return [
            'time.required' => 'Это поле обязательно для заполнения',
            'time.date_format' => 'Некорректное время',
            'time.after' => 'Некорректное время',
        ];
    }
}
