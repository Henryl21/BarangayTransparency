<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

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
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        try {
            $data = $request->only(['title', 'amount', 'date', 'category', 'description']);
            $data['type'] = 'expense';

            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/receipts', $filename);
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
            \Log::error('Store Expenditure Error:', ['exception' => $e]);

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
                if ($expenditure->receipt && Storage::exists('public/' . $expenditure->receipt)) {
                    Storage::delete('public/' . $expenditure->receipt);
                }

                $file = $request->file('receipt');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/receipts', $filename);
                $data['receipt'] = 'receipts/' . $filename;
            }

            $expenditure->update($data);

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')
                ->with('success', 'Expenditure updated successfully!')
                ->with('receipt_uploaded', $request->hasFile('receipt'));
        } catch (\Exception $e) {
            \Log::error('Update Expenditure Error:', ['exception' => $e]);

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

            if ($expenditure->receipt && Storage::exists('public/' . $expenditure->receipt)) {
                Storage::delete('public/' . $expenditure->receipt);
            }

            $expenditure->delete();

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')
                ->with('success', 'Expenditure deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Delete Expenditure Error:', ['exception' => $e]);

            return redirect()->back()
                ->with('error', 'Error deleting expenditure: ' . $e->getMessage());
        }
    }

    // NEW: Separate receipt view page
    public function showReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->receipt) {
            return redirect()->back()->with('error', 'No receipt found for this expenditure.');
        }

        if (!Storage::exists('public/' . $expenditure->receipt)) {
            return redirect()->back()->with('error', 'Receipt file not found in storage.');
        }

        return view('admin.expenditure.receipt', compact('expenditure'));
    }

    // View receipt file in the browser (inline)
    public function receipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->receipt) {
            abort(404, 'No receipt found.');
        }

        $path = storage_path('app/public/' . $expenditure->receipt);

        if (!file_exists($path)) {
            abort(404, 'Receipt file not found.');
        }

        return response()->file($path, [
            'Content-Type' => File::mimeType($path),
        ]);
    }

    // Store or update receipt via modal
    public function storeReceipt(Request $request, $id)
    {
        $request->validate([
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $expenditure = Budget::findOrFail($id);

            if ($expenditure->receipt && Storage::exists('public/' . $expenditure->receipt)) {
                Storage::delete('public/' . $expenditure->receipt);
            }

            $file = $request->file('receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/receipts', $filename);

            $expenditure->receipt = 'receipts/' . $filename;
            $expenditure->save();

            Cache::forget('dashboard_totals');
            Cache::forget('expenditure_totals');

            return redirect()->route('admin.expenditure.index')->with('success', 'Receipt uploaded successfully.');
        } catch (\Exception $e) {
            \Log::error('Store Receipt Error:', ['exception' => $e]);

            return redirect()->back()->with('error', 'Error uploading receipt: ' . $e->getMessage());
        }
    }

    // Alternative method to serve receipt directly as inline response
    public function serveReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->receipt || !Storage::exists('public/' . $expenditure->receipt)) {
            abort(404, 'Receipt not found');
        }

        $file = Storage::get('public/' . $expenditure->receipt);
        $type = Storage::mimeType('public/' . $expenditure->receipt);

        return response($file, 200)
            ->header('Content-Type', $type)
            ->header('Content-Disposition', 'inline');
    }

    // Download receipt file
    public function downloadReceipt($id)
    {
        $expenditure = Budget::findOrFail($id);

        if (!$expenditure->receipt || !Storage::exists('public/' . $expenditure->receipt)) {
            abort(404, 'Receipt not found');
        }

        return Storage::download('public/' . $expenditure->receipt);
    }
}