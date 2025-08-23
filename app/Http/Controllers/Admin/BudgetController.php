<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    /**
     * Display a listing of all budgets (with filters, search, pagination).
     */
    public function index(Request $request)
    {
        $query = Budget::query();

        // Search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Get paginated results (10 per page)
        $budgets = $query->paginate(10);

        // Keep query parameters in pagination links
        $budgets->appends($request->query());

        // Get all budgets for stats (without pagination)
        $allBudgets = Budget::all();

        return view('admin.budget.index', compact('budgets', 'allBudgets'));
    }

    /**
     * Display the dashboard with summary and all budgets.
     */
    public function dashboard()
    {
        $totalBudget = Budget::where('type', 'income')->sum('amount');
        $totalSpent = Budget::where('type', 'expense')->sum('amount');
        $totalRemaining = $totalBudget - $totalSpent;
        $budgets = Budget::latest()->get(); // all types for display

        $budgetChart = [
            'labels' => ['Income', 'Expense'],
            'data' => [$totalBudget, $totalSpent],
        ];

        return view('admin.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'budgets',
            'budgetChart'
        ));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create()
    {
        return view('admin.budget.create');
    }

    /**
     * Store a newly created budget record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:revenue,expense,income', // allow legacy "income"
            'amount' => 'required|numeric|min:0',
        ]);

        Budget::create($request->all());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Budget record created successfully.');
    }

    /**
     * Show the form to edit an existing budget.
     */
    public function edit(Budget $budget)
    {
        return view('admin.budget.edit', compact('budget'));
    }

    /**
     * Update the specified budget record.
     */
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:revenue,expense,income', // allow legacy "income"
            'amount' => 'required|numeric|min:0',
        ]);

        $budget->update($request->all());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Budget record updated successfully.');
    }

    /**
     * Remove the specified budget.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect()->route('admin.budget.index')
            ->with('success', 'Budget record deleted successfully.');
    }
}
