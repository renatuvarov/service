<?php

namespace App\Console\Commands\Search;

use App\Entity\City;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class Cities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): bool
    {
        try {
            $this->client->indices()->delete([
                'index' => 'cities'
            ]);
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => 'cities',
            'body' => [
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'city_name' => [
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

        City::chunk(200, function ($cities) {
            foreach ($cities as $city) {
                $this->client->index([
                    'index' => 'cities',
                    'id' => $city->id,
                    'body' => [
                        'id' => $city->id,
                        'city_name' => $city->city_name,
                    ],
                ]);
            }
        });

        return true;
    }
}
