<?php

namespace App\Http\Services;

use App\Events\ProfileDeleted;
use App\Http\Services\Elasticsearch\UsersService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class DeleteProfileService
{
    /**
     * @var UsersService
     */
    private $service;

    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }

    public function delete(User $user)
    {
        if (Redis::exists('order.' . $user->id)) {
            Redis::del('order.' . $user->id);
        }

        $this->service->delete($user);

        if (Auth::user()->id === $user->id) {
            Auth::logout();
        }

        $tickets = $user->tickets()->pluck('id')->toArray();
        event(new ProfileDeleted($tickets));

        $user->delete();
    }
}