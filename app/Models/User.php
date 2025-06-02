<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function Detail_assets()
    {
        return $this->belongsTo(Division::class);
    }

    public static function getRoleOptions(): array
    {
        return [
            'administrator' => 'Administrator',
            'validator' => 'Validator',
            'approver' => 'Approver',
            'viewer' => 'Viewer',
        ];
    }

    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isValidator(): bool
    {
        return $this->role === 'validator';
    }

    public function isApprover(): bool
    {
        return $this->role === 'approver';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }
}
