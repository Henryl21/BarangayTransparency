<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Announcement;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 💰 Totals
        $totalBudget = Budget::where('type', 'income')->sum('amount'); 
        $totalSpent = Budget::where('type', 'expense')->sum('amount');
        $totalRemaining = $totalBudget - $totalSpent;

        // 📦 All budgets
        $budgets = Budget::latest()->get();

        // 💸 Expenditures
        $expenditures = Budget::where('type', 'expense')->get();

        // 📅 Unique years for filtering
        $budgetYears = Budget::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 📊 Chart data preparation
        $budgetChart = [
            'labels' => [],
            'data' => [],
        ];

        if ($expenditures->isNotEmpty()) {
            $grouped = $expenditures->groupBy('category');
            $budgetChart['labels'] = $grouped->keys()->toArray();
            $budgetChart['data'] = $grouped->map(function ($item) {
                return $item->sum('amount');
            })->values()->toArray();
        }

        // 📢 Announcements
        $announcements = Announcement::latest()->get();

        // 🔄 Return to user dashboard view
        return view('user.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'budgets',
            'budgetChart',
            'budgetYears',
            'expenditures',
            'announcements'
        ));
    }
}
