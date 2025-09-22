<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_user_id',
        'title',
        'description',
        'amount',
        'receipt',
        'resolution',
        'status',
        'decline_reason',
    ];

    public function officer()
    {
        return $this->belongsTo(OfficerUser::class, 'officer_user_id');
    }
}
