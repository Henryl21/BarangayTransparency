<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'type',
        'category',
        'date',
        'receipt',  // add this line
    ];
    protected $casts = [
        'expense_date' => 'date',
    ];

    // Add this accessor to get the full URL
    public function getReceiptUrlAttribute()
    {
        if (!$this->receipt_path) {
            return null;
        }

        // Check if file exists before returning URL
        if (!Storage::exists($this->receipt_path)) {
            return null;
        }

        return Storage::url($this->receipt_path);
    }
}
