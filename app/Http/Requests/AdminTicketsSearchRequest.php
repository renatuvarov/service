<?php

namespace App\Http\Requests;

use App\Http\Services\SearchService;
use App\Rules\SearchCityRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AdminTicketsSearchRequest extends FormRequest
{
    /**
     * @var SearchService
     */
    private $service;

    public function __construct(SearchService $service, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->service = $service;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $after = '';

        if ($this->input('date') === Carbon::now()->format('Y-m-d')) {
            $after = '|after:' . Carbon::now()->format('H:i:s');
        }

        return [
            'date' => 'nullable|date_format:Y-m-d|after:yesterday',
            'departure_point' => ['nullable', 'string', 'min:4', 'max:50', 'different:arrival_point', new SearchCityRule($this->service)],
            'arrival_point' => ['nullable', 'string', 'min:4', 'max:50', 'different:departure_point', new SearchCityRule($this->service)],
            'time' => 'nullable|date_format:H:i:s' . $after,
            'seats' => 'nullable|integer|between:5,50'
        ];
    }

    public function messages()
    {
        return [
            'date.date_format' => 'Некорректная дата',

            'departure_point.string' => 'Значение поля должно быть строкой',
            'departure_point.min' => 'Значение поля должно быть не короче 4 символов',
            'departure_point.max' => 'Значение поля не должно превышать 50 символов',
            'departure_point.different' => 'Пункты отправления и прибытия должны отличаться',

            'arrival_point.string' => 'Значение поля должно быть строкой',
            'arrival_point.min' => 'Значение поля должно быть не короче 4 символов',
            'arrival_point.max' => 'Значение поля не должно превышать 50 символов',
            'arrival_point.different' => 'Пункты отправления и прибытия должны отличаться',

            'time.date_format' => 'Некорректное время',
            'time.after' => 'Некорректное время',

            'seats.between' => 'Минимальное количество мест: 5; максимальное: 50',
            'seats.integer' => 'Значение должно быть целым положительным числом числом',
        ];
    }
}
