<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class OfficerRequestController extends Controller
{
    public function index()
    {
        $expenditures = Budget::where('officer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.dashboard', compact('expenditures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only([
            'title', 'amount', 'category', 'description', 'date'
        ]);

        // Add officer ID and default status
        $data['officer_id'] = Auth::id();
        $data['status'] = 'pending';

        // Handle receipt upload
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        Budget::create($data);

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request submitted successfully!');
    }
}
