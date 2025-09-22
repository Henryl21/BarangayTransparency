<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show expenditures report (printable view).
     */
    public function printExpenditures()
    {
        // Get only expenditures (type = expense), ordered by latest date
        $expenditures = Budget::where('type', 'expense')
            ->orderBy('date', 'desc')
            ->get();

        // Calculate total spent
        $totalSpent = $expenditures->sum('amount');

        // Get barangay info/settings (logo, address, etc.)
        $settings = BarangaySetting::first();

        // Pass everything to the view
        return view('admin.reports.print', compact('expenditures', 'settings', 'totalSpent'));
    }
}
