<?php

namespace App\Http\Requests;

use App\Http\Services\SearchService;
use App\Rules\SearchCityRule;
use Illuminate\Foundation\Http\FormRequest;

class FindTickets extends FormRequest
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
        return [
            'date' => 'required|date_format:Y-m-d|after:yesterday',
            'departure_point' => ['required', 'string', 'min:4', 'max:50', 'different:arrival_point', new SearchCityRule($this->service)],
            'arrival_point' => ['required', 'string', 'min:4', 'max:50', 'different:departure_point', new SearchCityRule($this->service)],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Это поле обязательно для заполнения',
            'date.date_format' => 'Некорректная дата',

            'departure_point.required' => 'Это поле обязательно для заполнения',
            'departure_point.string' => 'Значение поля должно быть строкой',
            'departure_point.min' => 'Значение поля должно быть не короче 4 символов',
            'departure_point.max' => 'Значение поля не должно превышать 50 символов',
            'departure_point.different' => 'Пункты отправления и прибытия должны отличаться',

            'arrival_point.required' => 'Это поле обязательно для заполнения',
            'arrival_point.string' => 'Значение поля должно быть строкой',
            'arrival_point.min' => 'Значение поля должно быть не короче 4 символов',
            'arrival_point.max' => 'Значение поля не должно превышать 50 символов',
            'arrival_point.different' => 'Пункты отправления и прибытия должны отличаться',
        ];
    }
}
