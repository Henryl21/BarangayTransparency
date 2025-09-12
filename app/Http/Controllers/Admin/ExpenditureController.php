<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class ExpenditureController extends Controller
{
    // Display list of expenditures
    public function index()
    {
        $expenditures = Budget::where('type', 'expense')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSpent = $expenditures->sum('amount');

        return view('admin.expenditure.index', compact('expenditures', 'totalSpent'));
    }

    // Show form to create a new expenditure
    public function create()
    {
        return view('admin.expenditure.create');
    }

    // Store a new expenditure
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $data = $request->only(['title', 'amount', 'date', 'category', 'description']);
            $data['type'] = 'expense';

            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('public/receipts', $filename);
                
                // Store just the relative path without 'public/' prefix
                $data['receipt'] = 'receipts/' . $filename;
            }

            $expenditure = Budget::create($data);

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')
                ->with('success', 'Expenditure recorded successfully!')
                ->with('receipt_uploaded', $request->hasFile('receipt'))
                ->with('new_expenditure_id', $expenditure->id);
        } catch (\Exception $e) {
            \Log::error('Store Expenditure Error:', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Error adding expenditure: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Show form to edit an existing expenditure
    public function edit($id)
    {
        $expenditure = Budget::findOrFail($id);
        return view('admin.expenditure.edit', compact('expenditure'));
    }

    // Update an existing expenditure
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $expenditure = Budget::findOrFail($id);
            $data = $request->only(['title', 'amount', 'date', 'category', 'description']);

            if ($request->hasFile('receipt')) {
                // Delete old receipt if exists
                if ($expenditure->hasReceipt()) {
                    $oldPath = $expenditure->getReceiptStoragePath();
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                // Store new receipt
                $file = $request->file('receipt');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('public/receipts', $filename);
                
                // Store just the relative path without 'public/' prefix
                $data['receipt'] = 'receipts/' . $filename;
            }

            $expenditure->update($data);

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')
                ->with('success', 'Expenditure updated successfully!')
                ->with('receipt_uploaded', $request->hasFile('receipt'));
        } catch (\Exception $e) {
            \Log::error('Update Expenditure Error:', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Error updating expenditure: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Delete an expenditure
    public function destroy($id)
    {
        try {
            $expenditure = Budget::findOrFail($id);

            // Delete receipt file if exists
            if ($expenditure->hasReceipt()) {
                $storagePath = $expenditure->getReceiptStoragePath();
                if ($storagePath && Storage::exists($storagePath)) {
                    Storage::delete($storagePath);
                }
            }

            $expenditure->delete();

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')
                ->with('success', 'Expenditure deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Delete Expenditure Error:', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Error deleting expenditure: ' . $e->getMessage());
        }
    }

    // Show receipt view page - THIS METHOD WAS MISSING
    public function showReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->hasReceipt()) {
            return redirect()->back()->with('error', 'Receipt file not found for this expenditure.');
        }

        $receiptUrl = $expenditure->receipt_url;
        $isImage = $expenditure->isReceiptImage();

        // Debug logging
        \Log::info("Receipt Debug:", [
            'expenditure_id' => $id,
            'receipt_url' => $receiptUrl,
            'is_image' => $isImage,
            'has_receipt' => $expenditure->hasReceipt(),
            'receipt_field' => $expenditure->receipt,
            'storage_path' => $expenditure->getReceiptStoragePath()
        ]);

        return view('admin.expenditure.receipt', compact('expenditure', 'receiptUrl', 'isImage'));
    }

    // Serve receipt file directly (for direct image/PDF display)
    public function serveReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->hasReceipt()) {
            abort(404, 'No receipt found.');
        }

        $storagePath = $expenditure->getReceiptStoragePath();
        
        if (!$storagePath || !Storage::exists($storagePath)) {
            \Log::error("Receipt file not found:", [
                'expenditure_id' => $id,
                'storage_path' => $storagePath,
                'receipt_field' => $expenditure->receipt
            ]);
            abort(404, 'Receipt file not found.');
        }

        try {
            $contents = Storage::get($storagePath);
            $mimeType = $expenditure->getReceiptMimeType();
            $filename = basename($expenditure->receipt ?? $expenditure->receipt_path ?? 'receipt');

            return Response::make($contents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=3600',
                'Pragma' => 'public'
            ]);
        } catch (\Exception $e) {
            \Log::error('Receipt serving error:', [
                'expenditure_id' => $id,
                'error' => $e->getMessage(),
                'storage_path' => $storagePath
            ]);
            
            abort(500, 'Unable to display receipt.');
        }
    }

    // Download receipt
    public function downloadReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->hasReceipt()) {
            abort(404, 'Receipt not found');
        }

        $storagePath = $expenditure->getReceiptStoragePath();
        
        if (!$storagePath || !Storage::exists($storagePath)) {
            abort(404, 'Receipt file not found');
        }

        $originalName = basename($expenditure->receipt ?? $expenditure->receipt_path ?? 'receipt');
        
        return Storage::download($storagePath, $originalName);
    }

    // Upload or replace receipt
    public function storeReceipt(Request $request, $id)
    {
        $request->validate([
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $expenditure = Budget::findOrFail($id);

            // Delete old receipt if exists
            if ($expenditure->hasReceipt()) {
                $oldPath = $expenditure->getReceiptStoragePath();
                if ($oldPath && Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            // Store new receipt
            $file = $request->file('receipt');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('public/receipts', $filename);

            // Store just the relative path without 'public/' prefix
            $expenditure->receipt = 'receipts/' . $filename;
            $expenditure->save();

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')->with('success', 'Receipt uploaded successfully.');
        } catch (\Exception $e) {
            \Log::error('Store Receipt Error:', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()->with('error', 'Error uploading receipt: ' . $e->getMessage());
        }
    }
}