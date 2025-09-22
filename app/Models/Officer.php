<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'title',        // expenditure title
        'category',     // expenditure category
        'amount',       // expenditure amount
        'receipt',      // uploaded receipt path
        'status',       // pending / approved / declined
        'decline_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Accessor for receipt URL
    public function getReceiptUrlAttribute()
    {
        return $this->receipt ? asset('storage/' . $this->receipt) : null;
    }

    // Relationship: officer request can generate an expenditure
    public function expenditure()
    {
        return $this->hasOne(Expenditure::class);
    }
}
