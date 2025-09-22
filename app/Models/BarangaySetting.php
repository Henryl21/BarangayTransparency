<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangaySetting extends Model
{
    protected $fillable = [
        'barangay_name',
        'barangay_role', // ✅ keep role
        'logo',
    ];
}

