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

    public function getDeparturePoint()
    {
        return City::find($this->departure_point);
    }

    public function getArrivalPoint()
    {
        return City::find($this->arrival_point);
    }
}
