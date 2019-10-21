<?php

namespace App\Http\Services;

use Elasticsearch\Client;

class SearchService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($value)
    {
        return $this->client->search([
            'index' => 'cities',
            'body' => [
                'query' => [
                    'wildcard' => [
                        'city_name' => [
                            'value' => mb_strtolower($value),
                        ],
                    ],
                ],
            ],
        ]);
    }
}