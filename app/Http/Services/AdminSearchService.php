<?php

namespace App\Http\Services;

use App\Entity\Ticket;
use App\Http\Services\Elasticsearch\TicketService;
use App\User;
use Illuminate\Support\Str;

class AdminSearchService
{
    /**
     * @var TicketService
     */
    private $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
    }

    public function usersWithQuery($query, array $data)
    {
        if (! empty($data['email'])) {
            $userIds = User::where('email', 'like', '%' .  Str::lower($data['email']) . '%')->pluck('id')->toArray();
            $query->wherePivotIn('user_id', $userIds);
        }

        if (! empty($data['name'])) {
            $query->wherePivot('name', 'like', '%' .  Str::ucfirst(Str::lower($data['name'])) . '%');
        }

        if (! empty($data['surname'])) {
            $query->wherePivot('surname', 'like', '%' .  Str::ucfirst(Str::lower($data['surname'])) . '%');
        }

        if (! empty($data['patronymic'])) {
            $query->wherePivot('patronymic', 'like', '%' .  Str::ucfirst(Str::lower($data['patronymic'])) . '%');
        }

        if (! empty($data['phone'])) {
            $query->wherePivot('phone', $data['phone']);
        }

        if (! empty($data['status'])) {
            $query->wherePivot('status', 'waiting');
        }

        return $query;
    }

    public function ticketsWithQuery($query, array $data)
    {
        if (! empty($data)) {
            $query->whereIn('id', $this->service->get($data));
        }

        if (! empty($data['seats'])) {
            $query->where('seat', $data['seats']);
        }

        return $query;
    }
}