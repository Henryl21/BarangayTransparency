<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resolution;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Resolution::latest()->get();
        return view('admin.officers.approval', compact('approvals'));
    }

    public function updateStatus(Request $request, Resolution $resolution)
    {
        $request->validate([
            'status' => 'required|in:approved,declined'
        ]);

        $resolution->status = $request->status;
        $resolution->save();

        return response()->json([
            'message' => "Resolution status updated to {$request->status}."
        ]);
    }
}

