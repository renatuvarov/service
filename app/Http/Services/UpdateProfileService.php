<?php

namespace App\Http\Services;

use App\Http\Services\Elasticsearch\UsersService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpdateProfileService
{
    /**
     * @var UsersService
     */
    private $service;

    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }

    public function update(User $user, Request $request)
    {
        $user->update([
            'name' => is_null($request->input('name')) ? null : Str::ucfirst(Str::lower($request->input('name'))),
            'surname' => is_null($request->input('surname')) ? null : Str::ucfirst(Str::lower($request->input('surname'))),
            'patronymic' => is_null($request->input('patronymic')) ? null : Str::ucfirst(Str::lower($request->input('patronymic'))),
            'phone' => is_null($request->input('phone')) ? null : '+7' . $request->input('phone'),
        ]);

        $this->service->update($user);
    }
}