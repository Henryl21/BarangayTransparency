<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'type',
        'category',
        'date',
        'description',
        'receipt',
        'receipt_path',
        'barangay_role',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * Booted method to apply global scope and auto-assign barangay_role
     */
    protected static function booted()
    {
        // Filter budgets by authenticated admin's barangay_role
        static::addGlobalScope('barangay', function ($query) {
            if (Auth::guard('admin')->check()) {
                $adminBarangay = Auth::guard('admin')->user()->barangay_role;
                $query->where('barangay_role', $adminBarangay);
            }
        });

        // Auto-assign barangay_role on creating new budget
        static::creating(function ($budget) {
            if (Auth::guard('admin')->check() && !$budget->barangay_role) {
                $budget->barangay_role = Auth::guard('admin')->user()->barangay_role;
            }
        });
    }

    /**
     * Scope to get budgets for a specific barangay
     */
    public function scopeForBarangay($query, $barangayRole)
    {
        return $query->where('barangay_role', $barangayRole);
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /* =================== RECEIPT HANDLING =================== */

    // Get full URL to the receipt file
    public function getReceiptUrlAttribute()
    {
        $receiptPath = $this->receipt ?? $this->receipt_path;

        if (!$receiptPath) {
            return null;
        }

        $cleanPath = str_replace('public/', '', $receiptPath);

        if (!Storage::exists('public/' . $cleanPath)) {
            \Log::warning("Receipt file not found: public/{$cleanPath} for budget ID: {$this->id}");
            return null;
        }

        return asset('storage/' . $cleanPath);
    }

    // Check if receipt exists
    public function hasReceipt()
    {
        $receiptPath = $this->receipt ?? $this->receipt_path;

        if (!$receiptPath) return false;

        $cleanPath = str_replace('public/', '', $receiptPath);
        return Storage::exists('public/' . $cleanPath);
    }

    // Get receipt storage path
    public function getReceiptStoragePath()
    {
        $receiptPath = $this->receipt ?? $this->receipt_path;
        if (!$receiptPath) return null;
        return 'public/' . str_replace('public/', '', $receiptPath);
    }

    // Get receipt file extension
    public function getReceiptExtension()
    {
        $receiptPath = $this->receipt ?? $this->receipt_path;
        return $receiptPath ? strtolower(pathinfo($receiptPath, PATHINFO_EXTENSION)) : null;
    }

    // Check if receipt is an image
    public function isReceiptImage()
    {
        $extension = $this->getReceiptExtension();
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    // Get MIME type for receipt
    public function getReceiptMimeType()
    {
        $extension = $this->getReceiptExtension();
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'pdf' => 'application/pdf',
        ];
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    // Get receipt file size
    public function getReceiptFileSize()
    {
        $storagePath = $this->getReceiptStoragePath();
        if (!$storagePath || !Storage::exists($storagePath)) {
            return 0;
        }
        return Storage::size($storagePath);
    }

    // Format file size
    public function getReceiptFileSizeFormatted()
    {
        $size = $this->getReceiptFileSize();
        if ($size === 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = floor(log($size, 1024));
        return round($size / pow(1024, $power), 2) . ' ' . $units[$power];
    }
}
