<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OfficerUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'officer_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'role', // ✅ Added for role-based login
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Optional: cast attributes
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the password reset table for this guard.
     */
    public function getPasswordResetTable()
    {
        return 'officer_password_resets';
    }

    /**
     * Relationship to Officer profile (optional)
     */
    public function officerProfile()
    {
        return $this->hasOne(Officer::class, 'email', 'email');
    }

    /**
     * ✅ Helper method: Check if officer has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
