<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class OfficerApprovalController extends Controller
{
    /**
     * Display all pending officers for approval.
     */
    public function index()
    {
        $officers = Officer::latest()->get();
        return view('admin.officers.approval', compact('officers'));
    }

    /**
     * Approve the officer request.
     * Also auto-inserts into the expenditures table.
     */
    public function approve($id)
    {
        $officer = Officer::findOrFail($id);

        // Update officer status
        $officer->status = 'approved';
        $officer->decline_reason = null;
        $officer->save();

        // Auto-insert to expenditures
        Expenditure::create([
            'title'       => $officer->title ?? $officer->name,  // adjust based on Officer model fields
            'category'    => $officer->category ?? 'Uncategorized',
            'amount'      => $officer->amount ?? 0,
            'date'        => now(),
            'description' => "Auto-generated from Officer Approval (ID: {$officer->id})",
            'receipt'     => $officer->receipt ?? null,
            'status'      => 'approved',
        ]);

        return back()->with('success', 'Officer approved and expenditure recorded successfully.');
    }

    /**
     * Decline the officer request with reason.
     */
    public function decline(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $officer = Officer::findOrFail($id);
        $officer->status = 'declined';
        $officer->decline_reason = $request->input('reason');
        $officer->save();

        return back()->with('error', 'Officer declined with reason.');
    }

    /**
     * Show details of a specific officer.
     */
    public function show($id)
    {
        $officer = Officer::findOrFail($id);
        return view('admin.officers.show', compact('officer'));
    }

    /**
     * Delete an officer record (if needed).
     */
    public function destroy($id)
    {
        $officer = Officer::findOrFail($id);
        $officer->delete();

        return back()->with('success', 'Officer record deleted successfully.');
    }
}
