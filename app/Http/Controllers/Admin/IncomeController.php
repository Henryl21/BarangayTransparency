<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;

class IncomeController extends Controller
{
    // Show list of income records with optional filters
    public function index(Request $request)
    {
        $query = Budget::where('type', 'income');

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $incomes = $query->latest()->get();

        return view('admin.income.index', compact('incomes'));
    }

    // Show form to create new income
    public function create()
    {
        return view('admin.income.create');
    }

    // Store new income record
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Budget::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => 'income',
        ]);

        return redirect()->route('admin.income.index')->with('success', 'Income added successfully.');
    }

    // Show form to edit an income record
    public function edit($id)
    {
        $income = Budget::where('type', 'income')->findOrFail($id);
        return view('admin.income.edit', compact('income'));
    }

    // Update income record
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $income = Budget::where('type', 'income')->findOrFail($id);
        $income->update([
            'title' => $request->title,
            'amount' => $request->amount,
        ]);

        return redirect()->route('admin.income.index')->with('success', 'Income updated successfully.');
    }

    // Delete income record
    public function destroy($id)
    {
        $income = Budget::where('type', 'income')->findOrFail($id);
        $income->delete();

        return redirect()->route('admin.income.index')->with('success', 'Income deleted successfully.');
    }
}
