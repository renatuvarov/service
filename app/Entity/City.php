<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = ['id'];

    public function tickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'city_ticket',
            'city_id',
            'ticket_id'
        );
    }
}
