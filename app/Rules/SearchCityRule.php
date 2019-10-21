<?php

namespace App\Rules;

use App\Http\Services\SearchService;
use Illuminate\Contracts\Validation\Rule;

class SearchCityRule implements Rule
{
    /**
     * @var SearchService
     */
    private $service;

    public function __construct(SearchService $service)
    {
        //
        $this->service = $service;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = $this->service->search($value);
        return $result['hits']['total']['value'] === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Город не найден';
    }
}
