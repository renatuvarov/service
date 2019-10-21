<?php

namespace App\Http\Services;

use App\Entity\City;

class FindCitiesService
{
    /**
     * @var SearchService
     */
    private $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }

    public function findCity(string $departureCity, string $arrivalCity): array
    {
        $departurePoint = $this->service->search($departureCity);
        $arrivalPoint = $this->service->search($arrivalCity);

        return [
            'departure_point' => City::find($departurePoint['hits']['hits'][0]['_id']),
            'arrival_point' => City::find($arrivalPoint['hits']['hits'][0]['_id']),
        ];
    }
}