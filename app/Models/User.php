<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_seen',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen'         => 'datetime',
        ];
    }

    // ✅ Cek apakah user online (aktif dalam 5 menit terakhir)
    public function isOnline(): bool
    {
        return $this->last_seen && $this->last_seen->gt(Carbon::now()->subMinutes(5));
    }
}