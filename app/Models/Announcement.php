<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

   // app/Models/Announcement.php
protected $fillable = [
    'title',
    'content', // ✅ correct column name from migration
];

}
