<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Budget::expense()
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSpent = $expenditures->sum('amount');

        return view('admin.expenditure.index', compact('expenditures', 'totalSpent'));
    }

    public function create()
    {
        return view('admin.expenditure.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data['type'] = 'expense';

        if ($request->hasFile('receipt')) {
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        Budget::create($data);

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure recorded successfully!');
    }

    public function edit($id)
    {
        $expenditure = Budget::findOrFail($id);
        return view('admin.expenditure.edit', compact('expenditure'));
    }

    public function update(Request $request, $id)
    {
        $expenditure = Budget::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'remove_image'=> 'nullable|in:0,1'
        ]);

        // Remove old receipt if requested
        if ($request->remove_image == '1' && $expenditure->receipt) {
            Storage::disk('public')->delete($expenditure->receipt);
            $data['receipt'] = null;
        }

        // Upload new receipt
        if ($request->hasFile('receipt')) {
            if ($expenditure->receipt) {
                Storage::disk('public')->delete($expenditure->receipt);
            }
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expenditure->update($data);

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure updated successfully!');
    }

    public function destroy($id)
    {
        $expenditure = Budget::findOrFail($id);

        if ($expenditure->receipt) {
            Storage::disk('public')->delete($expenditure->receipt);
        }

        $expenditure->delete();

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure deleted successfully.');
    }
}
