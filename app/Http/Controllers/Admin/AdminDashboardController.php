<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated admin's barangay role
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        // 💰 Totals (filtered by barangay role)
        $totalBudget = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'income')
            ->sum('amount'); 

        $totalSpent = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'expense')
            ->sum('amount');

        $totalRemaining = $totalBudget - $totalSpent;

        // 📦 All budgets (filtered by barangay role)
        $budgets = Budget::where('barangay_role', $barangayRole)
            ->latest()
            ->get();

        // 💸 Expenditures (filtered by barangay role)
        $expenditures = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'expense')
            ->get();

        // 📅 Unique years for filtering (filtered by barangay role)
        $budgetYears = Budget::where('barangay_role', $barangayRole)
            ->selectRaw('YEAR(created_at) as year')
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
            $budgetChart['data'] = $grouped->map(fn($item) => $item->sum('amount'))
                                          ->values()
                                          ->toArray();
        }

        // 📢 Announcements (filtered by barangay role)
        $query = Announcement::where('barangay_role', $barangayRole);

        // 🔍 Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 📅 Month filter
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 📆 Year filter
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 🏷️ Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // ✅ Final announcements query
        $announcements = $query->orderBy('created_at', 'desc')->get();

        // Barangay info for display
        $barangayName = $currentAdmin->barangay_name ?? ucfirst($barangayRole);

        // 🔄 Return to dashboard view
        return view('admin.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'budgets',
            'budgetChart',
            'budgetYears',
            'expenditures',
            'announcements',
            'barangayName',
            'barangayRole'
        ));
    }

    // Optional AJAX search endpoint
    public function searchAnnouncements(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $searchTerm = $request->get('search', '');

        // Filter announcements by barangay role
        $announcements = Announcement::where('barangay_role', $barangayRole)
            ->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'announcements' => $announcements,
                'count' => $announcements->count()
            ]);
        }

        return redirect()->route('admin.dashboard', ['search' => $searchTerm]);
    }
}
