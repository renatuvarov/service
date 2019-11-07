<?php

namespace App;

use App\Entity\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    protected $guarded = [
        'id', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function roles()
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_USER,
        ];
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_user',
            'user_id',
            'ticket_id'
        );
    }

    public static function new(
        string $email,
        string $password,
        ?string $role = null,
        ?Carbon $verifiedAt = null,
        ?string $name = null,
        ?string $surname = null,
        ?string $patronymic = null
    ): self
    {
        return self::make([
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'email_verified_at' => $verifiedAt,
            'name' => $name,
            'surname' => $surname,
            'patronymic' => $patronymic,
        ]);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function changeRole($role): void
    {
        if (!in_array($role, self::roles())) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }

    public function hasFilledProfile()
    {
        return $this->name && $this->surname && $this->patronymic && $this->phone;
    }
}
