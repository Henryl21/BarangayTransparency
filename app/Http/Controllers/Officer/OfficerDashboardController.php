<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerDashboardController extends Controller
{
    public function index()
    {
        $expenditures = OfficerRequest::where('officer_user_id', Auth::guard('officer')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.dashboard', compact('expenditures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'required|numeric|min:0',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution'  => 'nullable|file|mimes:doc,docx,pdf|max:5120',
        ]);

        $receiptPath = $request->file('receipt')?->store('receipts', 'public');
        $resolutionPath = $request->file('resolution')?->store('resolutions', 'public');

        OfficerRequest::create([
            'officer_user_id' => Auth::guard('officer')->id(),
            'title'           => $request->title,
            'description'     => $request->description,
            'amount'          => $request->amount,
            'receipt'         => $receiptPath,
            'resolution'      => $resolutionPath,
            'status'          => 'pending',
        ]);

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request submitted successfully!');
    }
}
