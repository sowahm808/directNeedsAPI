<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // This allows mass assignment for role
        'fcm_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Role check methods for cleaner authorization logic
    public function isAdmin()
    {
        return $this->role === 'administrator';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isProcessor()
    {
        return $this->role === 'processor';
    }

    public function isAuditor()
    {
        return $this->role === 'auditor';
    }
}
