<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ElasticServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function (Application $app) {
            $config = $app->make('config')->get('elascticsearch');

            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries($config['retries'])
                ->build();
        });
    }

    public function boot()
    {
        //
    }
}
