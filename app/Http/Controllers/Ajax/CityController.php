<?php

namespace App\Http\Controllers\Ajax;

use App\Entity\City;
use App\Http\Controllers\Controller;
use App\Http\Services\SearchService;

class CityController extends Controller
{
    /**
     * @var SearchService
     */
    private $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }

    public function find(string $name)
    {
        $cities = $this->service->search($name . '*');
        $ids = array_column($cities['hits']['hits'], '_id');

        return City::whereIn('id', $ids)->orderBy('city_name')->pluck('city_name')->toJson();
    }
}
