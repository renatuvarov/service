<?php

namespace App\Http\Services\Elasticsearch;

use App\Entity\Ticket;
use Elasticsearch\Client;

class TicketService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createIndex(): void
    {
        $this->client->indices()->create([
            'index' => 'tickets',
            'body' => [
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'date' => [
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd',
                        ],
                        'time' => [
                            'type' => 'date',
                            'format' => 'HH:mm:ss',
                        ],
                        'departure_point' => [
                            'type' => 'text',
                        ],
                        'arrival_point' => [
                            'type' => 'text',
                        ],
                    ],
                ],
                'settings' => [
                    'max_ngram_diff' => 30,
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'my_ngram_tokenizer' => [
                                'type' => 'ngram',
                                'min_gram' => 4,
                                'max_gram' => 30,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'my_ngram_tokenizer',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function deleteIndex(): void
    {
        $this->client->indices()->delete([
            'index' => 'tickets',
        ]);
    }

    public function index(Ticket $ticket): void
    {
        $this->client->index([
            'index' => 'tickets',
            'id' => $ticket->id,
            'body' => [
                'id' => $ticket->id,
                'date' => $ticket->date->format('Y-m-d'),
                'time' => $ticket->time,
                'departure_point' => $ticket->departurePoint(),
                'arrival_point' => $ticket->arrivalPoint(),
            ],
        ]);
    }

    public function update(Ticket $ticket): void
    {
        $this->client->update([
            'index' => 'tickets',
            'id'    => $ticket->id,
            'body'  => [
                'doc' => [
                    'time' => $ticket->time,
                ],
            ],
        ]);
    }

    public function delete(Ticket $ticket): void
    {
        $this->client->delete([
            'index' => 'tickets',
            'id'    => $ticket->id,
        ]);
    }

    public function get(array $data): array
    {
        $result = $this->client->search([
            'index' => 'tickets',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => array_values(array_filter([
                            ! empty($data['date']) ? [
                                'range' => [
                                    'date' => [
                                        'gte' => $data['date'],
                                        'lte' => $data['date'],
                                    ],
                                ],
                            ] : false,
                            ! empty($data['time']) ? [
                                'range' => [
                                    'time' => [
                                        'gte' => $data['time'],
                                        'lte' => $data['time'],
                                    ],
                                ],
                            ] : false,
                            ! empty($data['departure_point']) ? [
                                'match' => [
                                    'departure_point' => $data['departure_point'],
                                ],
                            ] : false,
                            ! empty($data['arrival_point']) ? [
                                'match' => [
                                    'arrival_point' => $data['arrival_point'],
                                ],
                            ] : false,
                        ])),
                    ],
                ],
            ],
        ]);

        return array_column($result['hits']['hits'], '_id');
    }
}