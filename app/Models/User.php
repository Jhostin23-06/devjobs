<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method \Illuminate\Notifications\DatabaseNotificationCollection notifications()
 * @method \Illuminate\Notifications\DatabaseNotificationCollection unreadNotifications()
 * @method \Illuminate\Notifications\DatabaseNotificationCollection readNotifications()
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Obtener todas las notificaciones sin marcar como leídas
     */
    public function todasLasNotificaciones()
    {
        return $this->notifications();
    }

    /**
     * Obtener notificaciones no leídas
     */
    public function notificacionesNoLeidas()
    {
        return $this->unreadNotifications();
    }

    /**
     * Obtener notificaciones leídas
     */
    public function notificacionesLeidas()
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Scope para notificaciones leídas
     */
    public function scopeNotificacionesLeidas($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNotificacionesNoLeidas($query)
    {
        return $query->whereNull('read_at');
    }

}
