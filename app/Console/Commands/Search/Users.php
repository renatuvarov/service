<?php

namespace App\Console\Commands\Search;

use App\Http\Services\Elasticsearch\UsersService;
use App\User;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class Users extends Command
{
    protected $signature = 'search:users';
    protected $description = 'Command description';
    /**
     * @var UsersService
     */
    private $service;

    public function __construct(UsersService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        try {
            $this->service->deleteIndex();
        } catch (Missing404Exception $e) {}

        $this->service->createIndex();

        foreach (User::cursor() as $user) {
            $this->service->index($user);
        }

        return true;
    }
}
