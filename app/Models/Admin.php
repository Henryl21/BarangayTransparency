<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'barangay_role',
        'barangay_name'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Automatically hash the password when set
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password) && Hash::needsRehash($password)) {
            $this->attributes['password'] = Hash::make($password);
        } else {
            $this->attributes['password'] = $password;
        }
    }

    /**
     * Get all available barangays in Madridejos
     */
    public static function getBarangays()
    {
        return [
            'bunakan' => 'Bunakan',
            'kangwayan' => 'Kangwayan', 
            'kaongkod' => 'Kaongkod',
            'kodia' => 'Kodia',
            'maalat' => 'Maalat',
            'malbago' => 'Malbago',
            'mancilang' => 'Mancilang',
            'tarong' => 'Tarong',
            'pili' => 'Pili',
            'poblacion' => 'Poblacion',
            'san-agustin' => 'San-agustin',
            'tabagak' => 'Tabagak',
            'talangnan' => 'Talangnan',
            'tugas' => 'Tugas'
        ];
    }

    /**
     * Get formatted barangay name
     */
    public function getBarangayNameAttribute()
    {
        $barangays = self::getBarangays();
        return $barangays[$this->barangay_role] ?? ucfirst(str_replace('_', ' ', $this->barangay_role));
    }

    /**
     * Get full URL for profile photo
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/admin_profiles/' . $this->profile_photo);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Check if admin has specific barangay role
     */
    public function hasBarangayRole($barangay)
    {
        return $this->barangay_role === $barangay;
    }

    /**
     * Get admin's barangay jurisdiction
     */
    public function getJurisdiction()
    {
        return $this->barangay_name ?? $this->getBarangayNameAttribute();
    }

    /**
     * Get budgets for this admin's barangay
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class, 'barangay_role', 'barangay_role');
    }

    /**
     * Check if admin is for Malbago barangay
     */
    public function isMalbagoAdmin()
    {
        return $this->barangay_role === 'malbago';
    }

    /**
     * Scope to get admins from specific barangay
     */
    public function scopeForBarangay($query, $barangayRole)
    {
        return $query->where('barangay_role', $barangayRole);
    }
}
