<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'barangay_role',
        'published_at',
    ];

    // 👇 make sure Laravel knows these are dates
    protected $casts = [
        'published_at' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}

