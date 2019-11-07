<?php

namespace App\Http\Services\Elasticsearch;

use App\User;
use Elasticsearch\Client;

class UsersService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createIndex(): void
    {
        $this->client->indices()->create([
            'index' => 'users',
            'body' => [
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'text',
                        ],
                        'surname' => [
                            'type' => 'text',
                        ],
                        'patronymic' => [
                            'type' => 'text',
                        ],
                        'email' => [
                            'type' => 'keyword',
                        ],
                        'verified' => [
                            'type' => 'keyword',
                        ],
                        'role' => [
                            'type' => 'keyword',
                        ],
                        'phone' => [
                            'type' => 'long',
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
            'index' => 'users',
        ]);
    }

    private function prepareData(User $user): array
    {
        $data = array_filter([
            ! is_null($user->name) ? [
                'name' => $user->name,
            ] : false,
            ! is_null($user->surname) ? [
                'surname' => $user->surname,
            ] : false,
            ! is_null($user->patronymic) ? [
                'patronymic' => $user->patronymic,
            ] : false,
            ! is_null($user->email) ? [
                'email' => $user->email,
            ] : false,
            ! is_null($user->email_verified_at) ? [
                'verified' => 'verified',
            ] : false,
            ! is_null($user->role) ? [
                'role' => $user->role,
            ] : false,
            ! is_null($user->phone) ? [
                'phone' => str_replace('+7', '', $user->phone),
            ] : false,
        ]);

        $result = [];

        foreach($data as $item){
            $result = array_merge($result, $item);
        }
        
        return $result;
    }

    public function index(User $user)
    {
        $this->client->index([
            'index' => 'users',
            'id' => $user->id,
            'body' => $this->prepareData($user),
        ]);
    }

    public function update(User $user)
    {
        $this->client->update([
            'index' => 'users',
            'id'    => $user->id,
            'body'  => [
                'doc' => $this->prepareData($user),
            ],
        ]);
    }

    public function delete(User $user)
    {
        $this->client->delete([
            'index' => 'users',
            'id'    => $user->id,
        ]);
    }

    public function get(array $data): array
    {
        $result = $this->client->search([
            'index' => 'users',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => array_values(array_filter([
                            ! empty($data['name']) ? [
                                'match' => [
                                    'name' => $data['name'],
                                ],
                            ] : false,
                            ! empty($data['surname']) ? [
                                'match' => [
                                    'surname' => $data['surname'],
                                ],
                            ] : false,
                            ! empty($data['patronymic']) ? [
                                'match' => [
                                    'patronymic' => $data['patronymic'],
                                ],
                            ] : false,
                            ! empty($data['email']) ? [
                                'term' => [
                                    'email' => $data['email'],
                                ],
                            ] : false,
                            ! empty($data['verified']) ? [
                                'term' => [
                                    'verified' => 'verified',
                                ],
                            ] : false,
                            ! empty($data['phone']) ? [
                                'term' => [
                                    'phone' => $data['phone'],
                                ],
                            ] : false,
                            ! empty($data['role']) ? [
                                'term' => [
                                    'role' => $data['role'],
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