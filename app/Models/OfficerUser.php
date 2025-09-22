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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship: link to officer profile
    public function officerProfile()
    {
        return $this->hasOne(Officer::class, 'email', 'email');
    }
}
