<?php

namespace App\Entity;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'date' => 'date',
    ];

    public function cities()
    {
        return $this->belongsToMany(
            City::class,
            'city_ticket',
            'ticket_id',
            'city_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'ticket_user',
            'ticket_id',
            'user_id'
        );
    }

    public function departurePoint()
    {
        return $this->cities->first(function($item) {
            return $item->id == $this->departure_point;
        })->city_name;
    }

    public function arrivalPoint()
    {
        return $this->cities->first(function($item) {
            return $item->id == $this->arrival_point;
        })->city_name;
    }
}
