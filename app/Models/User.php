<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'number',
        'age',
        'birthdate',
        'email',
        'password',
        'profile_photo',
        'barangay_role', // ✅ renamed from barangay_place
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ✅ List of barangays (for dropdowns etc.)
     */
    public static function getBarangays(): array
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
            'tugas' => 'Tugas',
        ];
    }

    /**
     * ✅ Smart password mutator: only hash plain-text passwords.
     */
    public function setPasswordAttribute($value)
    {
        // Only hash if it's not already a bcrypt hash
        if (!Hash::info($value)['algo']) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * ✅ Profile Photo Accessor
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/profile_photos/' . $this->profile_photo))) {
            return asset('storage/profile_photos/' . $this->profile_photo);
        }

        // fallback → auto initials avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
    }
}
